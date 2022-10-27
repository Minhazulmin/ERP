<template>
    <div>

        <!-- ==========Menu tags============= -->
        <section
            class="content-header"
            v-if="Object.keys(breadcrumbLevels).length > 0">
            <div class="d-flex align-items-center">
                <h1>
                    {{breadcrumbLevels[0] ? breadcrumbLevels[0][Object.keys(breadcrumbLevels[0]).length - 1]["title"] : "" }}
                </h1>
<!--                <section class="menu-tags" v-if="Object.keys(menuTags).length > 0">-->
<!--                    <ul class="tags">-->
<!--                        <slot v-for="(menuName, index) in menuTags">-->
<!--                            <li-->
<!--                                :key="index"-->
<!--                                :class="menuName.route == $route.name ? 'active' : ''"-->
<!--                            >-->
<!--                                <router-link-->
<!--                                    v-if="menuName.route == 'admin.dashboard'"-->
<!--                                    :to="{ name: menuName.route }"-->
<!--                                 >-->
<!--                                    {{ menuName.title }}-->
<!--                                    <i-->
<!--                                        v-if="index != 0"-->
<!--                                        @click="removeMenu(index)"-->
<!--                                        class="fa fa-times"-->
<!--                                    ></i>-->
<!--                                </router-link>-->
<!--                                <router-link-->
<!--                                    v-if="$root.checkPermission(menuName.route)"-->
<!--                                    :to="{-->
<!--                name: menuName.route,-->
<!--                params: { slug: menuName.slug ? menuName.slug : '' },-->
<!--              }"-->
<!--                                >-->
<!--                                    {{ menuName.title }}-->
<!--                                    <i-->
<!--                                        v-if="index != 0"-->
<!--                                        @click="removeMenu(index)"-->
<!--                                        class="fa fa-times"-->
<!--                                    ></i>-->
<!--                                </router-link>-->
<!--                            </li>-->
<!--                        </slot>-->
<!--                        &lt;!&ndash; <li class="router-link-active">-->
<!--                          <a href="#">Dashboard</a>-->
<!--                        </li>&ndash;&gt;-->
<!--                    </ul>-->
<!--                </section>-->
            </div>

<!--            <ol class="breadcrumb">-->
<!--                <li>-->
<!--                    <router-link :to="{ name: 'admin.dashboard' }">Dashboard</router-link>-->
<!--                </li>-->
<!--                <li v-for="(menu, index1) in breadcrumbLevels[0]" :key="index1">-->
<!--                    <router-link :to="{ name: menu.route,params: { slug: menu.slug ? menu.slug : '' },}">{{ menu.title }}</router-link>-->
<!--                </li>-->
<!--            </ol>-->
            <section class="menu-tags" v-if="Object.keys(breadcrumbLevels[0]).length > 0">
                <ul class="tags">
                    <li>
                        <router-link :to="{ name: 'admin.dashboard' }">Dashboard</router-link>
                    </li>
                    <li v-for="(menu, index1) in breadcrumbLevels[0]" :key="index1" :class="menu.route == $route.name ? 'active' : ''">
                        <router-link :to="{name: menu.route, params: { slug: menu.slug ? menu.slug : '' },}">
                            {{ menu.title }}
                        </router-link>
                    </li>
                </ul>
            </section>
        </section>

    </div>
</template>

<script>
export default {
    methods: {
        removeMenu(index) {
            breadcrumbs.dispatch("removeMenu", index);
        },
    },
    computed: {
        breadcrumbLevels() {
            return breadcrumbs.state.breadcrumbLevels;
        },
        menuTags() {
            return breadcrumbs.state.menuTags;
        },
    },
};
</script>
