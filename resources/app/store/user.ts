import type { InertiaForm } from "@inertiajs/inertia-vue3";
import type { PaginationI, UserI } from "@/types";
import { defineStore } from "pinia";
import { pick } from "lodash";
import { api } from "@services/main";

export const useUserStore = defineStore("user", {
	state: () => ({
		lifecycles: {
			onMount: false,
			onMountUsers: false,
		},
		loadings: {
			update: false,
			updateUsers: false,
			updatePassword: false,
		},
		currentUser: <UserI | null>null,
		users: <PaginationI<UserI>>{
			data: [],
			links: []
		},
	}),
	getters: {
		isBanning: ({ currentUser }) => currentUser?.isAdmin || !currentUser?.banning,
		isAdmin: ({ currentUser }) => currentUser?.isAdmin,
	},
	actions: {
		getUsers(forcing = false, page = 1) {
			if (forcing || !this.lifecycles.onMountUsers) {
				this.lifecycles.onMountUsers = true;
				this.loadings.updateUsers = true;

				return api.get("/user/profile/all", { params: { page } })
					.then((resp) => {
						this.users = resp.data;
					})
					.catch(() => this.lifecycles.onMountUsers = false)
					.finally(() => setTimeout(() => this.loadings.updateUsers = false, 200))
			}

			return new Promise<void>((resolve) => resolve())
		},

		getCurrentUser(forcing = false) {
			if (forcing || !this.lifecycles.onMount) {
				this.lifecycles.onMount = true;

				return api.get("/user/profile/show")
					.then((resp) => {
						this.currentUser = resp.data.user;
					})
					.catch(() => this.lifecycles.onMount = false)
			}

			return new Promise<boolean>((resolve) => resolve(false))
		},

		updateUserByAdmin(form: UserI) {
			return api
				.post("/user/profile/update-by-admin", { ...form, user_id: form.id })
				.then((resp) => resp.data)
		},

		updateCurrentUser(form: InertiaForm<{ name: string; image: string | Blob; email: string; }>) {
			this.loadings.update = true;

			const formData = new FormData();
			formData.append("image", form.image);
			formData.append("email", form.email);
			formData.append("name", form.name);

			return api
				.post("/user/profile/update", formData)
				.then((resp) => {
					setTimeout(() => this.currentUser = resp.data.user, 200);
					form.clearErrors()
					form.reset();
					return resp.data;
				})
				.catch((error) => {
					const errors = error.response.data.errors;
					for (const field in errors) {
						form.setError(field as typeof errors, errors[field][0]);
					}
				}).finally(() => {
					setTimeout(() => this.loadings.update = false, 200)
				})
		},

		updateUserPassword(form: InertiaForm<{ check_new_password: string; current_password: string; new_password: string; }>) {
			this.loadings.updatePassword = true
			return api
				.post("/user/profile/change-password", pick(form, [
					"check_new_password",
					"current_password",
					"new_password",
				]))
				.then((resp) => {
					form.clearErrors()
					form.reset();
					return resp.data
				})
				.catch((error) => {
					const errors = error.response.data.errors;
					for (const field in errors) {
						form.setError(field as typeof errors, errors[field][0]);
					}
				})
				.finally(() => {
					setTimeout(() => this.loadings.updatePassword = false, 200)
				})
		},

		resetAll() {
			this.lifecycles.onMount = false;
			this.loadings.update = false;
			this.loadings.updatePassword = false;
			this.currentUser = null;
		}
	},
});
