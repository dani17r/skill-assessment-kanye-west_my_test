import type { FavoriteI } from '@/types';
import { defineStore } from "pinia";
import axios from "axios";
import { remove } from 'lodash';
import { useQuoteStore } from './quote';

export const useFavoriteStore = defineStore("favorite", {
	state: () => ({
		lifecycles: {
			onMount: false,
			scrolling: true,
		},
		loadings: {
			init: false,
		},
		favorites: <FavoriteI[]>[],
		pag: 1,
	}),
	actions: {
		getFavorites(forcing = false) {
			if (forcing || !this.lifecycles.onMount) {
				this.lifecycles.onMount = true;
				this.loadings.init = true;

				return axios.get<{ data: FavoriteI[] }>("/favorite/all", { params: { page: this.pag, limit: 20 } })
					.then((resp) => {
						if (!resp.data.data.length) {
							this.lifecycles.scrolling = false;
						} else this.pag += 1;

						if (this.favorites.length) this.favorites.push(...resp.data.data);
						else this.favorites = resp.data.data;
					})
					.finally(() => setTimeout(() => this.loadings.init = false, 200))
			}

			return new Promise<void>((resolve) => resolve())
		},

		updateOrCreateaFavorite(status: string, form: FavoriteI) {
			return axios.post<FavoriteI>('/favorite', form)
				.then((resp) => {
					if (this.favorites.length) {
						if (status == 'updated') {
							this.favorites.map((item) => {
								if (item.quote == resp.data.quote) {
									item.dislike = resp.data.dislike;
									item.like = resp.data.like;
								}
								return item
							})
						}
					}
					if (status == 'created') {
						useQuoteStore().totalFavorites += 1
						this.favorites.unshift(resp.data);
					}
				})
		},

		deleteFavorite(form: FavoriteI) {
			return axios.post<FavoriteI>('/favorite/delete', { quote: form.quote })
				.then(() => {
					if (this.favorites.length) {
						useQuoteStore().totalFavorites -= 1
						remove(this.favorites, (item: FavoriteI) => {
							return item.quote == form.quote
						});
					}
				})
		},
		resetAll() {
			this.lifecycles.scrolling = false;
			this.lifecycles.onMount = false;
			this.loadings.init = false;
			this.favorites = [];
			this.pag = 0;
		}
	},
});
