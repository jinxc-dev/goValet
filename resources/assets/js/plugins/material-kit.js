import VueMaterial from "vue-material";
import "vue-material/dist/vue-material.min.css";
import "@/../scss/material-kit.scss";
import "@/../common.scss";
import globalDirectives from "./globalDirectives";
import globalMixins from "./globalMixins";
import globalComponents from "./globalComponents";
import VueLazyload from "vue-lazyload";
import VueCarousel from "vue-carousel";
import VeeValidate from 'vee-validate';


export default {
  install(Vue) {
    Vue.use(VueMaterial);
    Vue.use(globalDirectives);
    Vue.use(globalMixins);
    Vue.use(globalComponents);
    Vue.use(VueCarousel);
    Vue.use(VeeValidate, { fieldsBagName: 'veeFields' });
    Vue.use(VueLazyload, {
      observer: true,
      // optional
      observerOptions: {
        rootMargin: "0px",
        threshold: 0.1
      }
    });
  }
};
