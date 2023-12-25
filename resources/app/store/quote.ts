// import { useUserStore } from "@store/user";
import { defineStore } from "pinia";
import axios from 'axios';

export const useQuoteStore = defineStore("quote", {
  state: () => ({
    lifecycles: {
      onMount: false,
    },
    loadings: {
      init: false,
      updateOrCreate:false
    },
    quotes: [],
  }),
  getters: {},
  actions: {
    getQuotes(forcing=false) {
      if (forcing || !this.lifecycles.onMount) {
        this.lifecycles.onMount = true;
        this.loadings.init = true

        // const userStore = useUserStore();

        return axios.get('api/quotes')
          .then((resp) => {
            this.quotes = resp.data
            this.quotes.map((item)=> {
              // const favorite = userStore.favoritesKey[item.quote]
              // if (favorite) {
              //   item.like = favorite.like;
              //   item.dislike = favorite.dislike;
              // }
              // else {
              //   item.like = false;
              //   item.dislike = false;
              // }
              return item
            })
          })
          .finally(() => setTimeout(() => this.loadings.init = false, 200))
      }

      return new Promise<void>((resolve) => resolve())
    },

    updateOrCreateaFavoriteQuote(form: { like: boolean, dislike:boolean, quote: string}) {
      this.loadings.updateOrCreate = true

      return axios.post('/favorite', form)
        .then((resp) => {
          this.quotes.map((item) => {
            if (resp.data.quote == item.quote){
              item.like = resp.data.like;
              item.dislike = resp.data.dislike;
              return item
            }
          })
        })
        .finally(() => setTimeout(() => this.loadings.updateOrCreate = false, 200))
    },
  }
});
