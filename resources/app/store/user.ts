import type { InertiaForm } from "@inertiajs/inertia-vue3";
import { defineStore } from "pinia";
import { pick } from "lodash";
import axios from "axios";

export const useUserStore = defineStore("user", {
	state: () => ({
		lifecycles: {
			onMount: false,
		},
		loadings: {
			update: false,
			updatePassword: false,
		},
		currentUser: null,
	}),
	getters: {},
	actions: {
		getCurrentUser() {
			if (!this.lifecycles.onMount) {
				this.lifecycles.onMount = true;
				
				return axios.get("/user/profile/show").then((resp) => {
					this.currentUser = resp.data.user;
				});
			}

			return new Promise<void>((resolve) => resolve())
		},

		updateCurrentUser(form: InertiaForm<{ name: string; image: string|Blob; email: string; }>) {
			this.loadings.update = true;

			const formData = new FormData();
			formData.append("image", form.image);
			formData.append("email", form.email);
			formData.append("name", form.name);

			return axios
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
				}).finally(()=> {
					setTimeout(() => this.loadings.update = false, 100)
				})
		},

		updateUserPassword(form: InertiaForm<{ check_new_password: string; current_password: string; new_password: string; }>) {
			this.loadings.updatePassword = true
			return axios
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
					setTimeout(() => this.loadings.updatePassword = false, 100)
				})
		},
		emptyCurrentUser(){
			this.lifecycles.onMount = false;
			this.loadings.update = false;
			this.loadings.updatePassword = false;
			this.currentUser = null;
		}
	},
});
