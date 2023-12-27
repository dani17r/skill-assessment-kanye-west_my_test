import type { FavoriteI, QuoteI, RespQuoteI } from '@/types';
import { defineStore } from "pinia";
import axios from 'axios';

export const useQuoteStore = defineStore("quote", {
  state: () => ({
    lifecycles: {
      onMount: false,
    },
    loadings: {
      init: false,
      updateOrCreate: false
    },
    quotes: <QuoteI[]>[],
    totalFavorites: 0,
    limit: 5,
    limitSelect: [5, 7, 10, 12, 15, 20]
  }),
  actions: {
    getQuotes(forcing = false) {
      if (forcing || !this.lifecycles.onMount) {
        this.lifecycles.onMount = true;
        this.loadings.init = true

        return axios.get<RespQuoteI>('/quotes', { params: { limit: this.limit } })
          .then((resp) => {
            this.quotes = resp.data.data;
            this.totalFavorites = resp.data.total_favorites;
          })
          .finally(() => setTimeout(() => this.loadings.init = false, 200))
      }

      return new Promise<boolean>((resolve) => resolve(false))
    },
    updateQuotesByFavorites(favorite: FavoriteI) {
      this.quotes.map((item) => {
        if (item.quote == favorite.quote) {
          item.dislike = favorite.dislike;
          item.like = favorite.like;
          return item;
        }
      });
    },
    resetAll() {
      this.loadings.updateOrCreate = false;
      this.lifecycles.onMount = false;
      this.loadings.init = false;
      this.totalFavorites = 0;
      this.quotes = [];
    }
  }
});
