<template>
    <div v-if="!$root.spinner">
        <div class="row">
            <div v-for="(menu, index) in menus" :key="index" class="col-md-3 col-sm-6 col-xs-12">
                <router-link :to="{name:menu.route_name, params:{slug:menu.params}}">
                    <div class="info-box d-flex align-items-center">
            <span class="info-box-icon" :class="'bg-color-'+(index+1)">
              <em v-if="menu.icon" v-html="menu.icon" class="fa-icon"></em>
            </span>

                        <div class="info-box-content row ml-1">
                            <span class="info-box-text">{{ menu.menu_name }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                </router-link>
                <!-- /.info-box -->
            </div>
        </div>
    </div>
</template>

<script>
const breadcrumb = [{route: "admin.dashboard", title: "Dashboard"}];
export default {
    data() {
        return {
            menus: [],
        };
    },
    methods: {
        getMenus() {
            this.$root.$loader.$emit('loading', true)
            axios
                .get("/get-dashboard-menus")
                .then((res) => (this.menus = res.data))
                .catch((error) => console.log())
                .then((alw) => setTimeout(() => (this.$root.$loader.$emit('loading', false)), 500));
        },
    },
    created() {
        this.getMenus();
        breadcrumbs.dispatch("setBreadcrumbs", breadcrumb);
    },
};
</script>
<style>
.btn .badge {
    position: absolute;
}

.btn.btn-app {
    width: 105px;
    font-size: 12px;
    white-space: inherit;
    height: 90px;
}
</style>
