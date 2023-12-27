import { defineAsyncComponent } from "vue";

export default {
  Exclamation: defineAsyncComponent(()=> import('@components/icons/Exclamation.vue')),
  Dislike: defineAsyncComponent(()=> import('@components/icons/Dislike.vue')),
  Refresh: defineAsyncComponent(()=> import('@components/icons/Refresh.vue')),
  EyeHide: defineAsyncComponent(()=> import('@components/icons/EyeHide.vue')),
  Danger: defineAsyncComponent(()=> import('@components/icons/Danger.vue')),
  Check: defineAsyncComponent(()=> import('@components/icons/Check.vue')),
  Close: defineAsyncComponent(()=> import('@components/icons/Close.vue')),
  Like: defineAsyncComponent(()=> import('@components/icons/Like.vue')),
  Docs: defineAsyncComponent(()=> import('@components/icons/Docs.vue')),
  Min: defineAsyncComponent(()=> import('@components/icons/Min.vue')),
  Max: defineAsyncComponent(()=> import('@components/icons/Max.vue')),
  Eye: defineAsyncComponent(()=> import('@components/icons/Eye.vue')),
}