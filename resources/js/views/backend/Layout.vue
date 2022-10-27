<template>
  <div class="wrapper">
    <!--============ Header start ============-->
    <Header />

    <!--============ Left Menu start ============-->
    <LeftMenu />

    <div class="content-wrapper">
      <!-- VALIDATION MESSAGE -->
      <ValidationMessage />
      <!-- VALIDATION MESSAGE -->

      <!--============ Breadcrumbs ============-->
      <Breadcrumbs />
      <!--============ /Breadcrumbs ============-->

      <!--============ Main content ============-->
      <section class="content">
        <router-view></router-view>
        <div class="box box-success p-5" v-if="$root.spinner">
          <div
            class="row d-flex align-items-center justify-content-center"
            style="height: 350px"
          >
            <spinner />
          </div>
        </div>
      </section>

        <div class="mian-loader" v-if="isMainLoader">
            <div class="loader">
                <img :src="$root.baseurl + '/images/loader.gif'" alt="">
            </div>
        </div>
      <!--============ /Main content ============-->
    </div>
    <!--============ footer start ============-->
    <!--<Footer />-->
    <!--============ footer end ============-->
  </div>
</template>

<script>
import Header from "./../../components/backend/Header";
import LeftMenu from "./../../components/backend/LeftMenu";
import Footer from "./../../components/backend/Footer";
import Breadcrumbs from "./../../components/backend/elements/Breadcrumbs";
import ValidationMessage from "./../../components/backend/elements/ValidationMessage";
export default {
  components: {
    Breadcrumbs,
    Header,
    LeftMenu,
    Footer,
    ValidationMessage,
  },
    data(){
      return{
          isMainLoader:false,
      }
    },

    created() {
      this.$root.$loader.$on('loading',playload =>{
          this.isMainLoader = playload
      });
    },
    beforeCreate() {
    if (!Admin.id()) {
      Admin.logout();
    }
  },
};
</script>
<style >
.mian-loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 85%;
    height: 100%;
    z-index: 1234;
    background: #f0f8ffe0;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-left: 19em;
    text-align: center;
}
</style>
