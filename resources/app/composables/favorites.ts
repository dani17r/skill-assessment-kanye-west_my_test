
import { useFavoriteStore } from '@store/favorites';
import type { FavoriteI } from '@/types';
import { storeToRefs } from 'pinia';

export default () => {

  const favoriteStore = useFavoriteStore();
  const { favorites, loadings, lifecycles } = storeToRefs(favoriteStore);

  const changeInFavorite = (type: 'like' | 'dislike', item: FavoriteI) => {
    let status = 'created';

    if (!item.dislike && !item.like) {
      status = 'created';
    }
    else status = 'updated'

    if (type == 'like') {
      item.like = !item.like;
      item.dislike = false;
    }
    else {
      item.dislike = !item.dislike;
      item.like = false;
    }

    if (!item.dislike && !item.like) {
      favoriteStore.deleteFavorite(item);
    }
    else favoriteStore.updateOrCreateaFavorite(status, item);
  }

  return {
    changeInFavorite,
    favoriteStore,
    favorites,
    loadings,
    lifecycles,
  }

} 