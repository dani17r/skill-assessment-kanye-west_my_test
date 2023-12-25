import { defineStore } from "pinia";
import { keyBy } from "lodash";
import axios from "axios";

export const useFavoriteStore = defineStore("favorite", {
	state: () => ({
		lifecycles: {
			onMount: false,
		},
		loadings: {
			init: false,
		},
		favorites: null,
		favoritesKey: null,
	}),
	getters: {},
	actions: {
		getFavorites() {
			if (!this.lifecycles.onMount) {
				this.lifecycles.onMount = true;
				
				return axios.get("/favorites/all").then((resp) => {
					this.favorites = resp.data;
					this.favoritesKey = keyBy(resp.data, 'quote');
				});
			}

			return new Promise<void>((resolve) => resolve())
		},
	},
});
