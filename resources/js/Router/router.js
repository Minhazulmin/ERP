import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// ========== define route==========
const routes = [
    { path: '/loginme', name: 'admin.loginme', component: () => import('./../views/login/Login') },

    { // allow for after login
        path: '/dashboard', component: () => import('./../views/backend/Layout'), beforeEnter: authGuard,
        // chlidren menu
        children: [
            // ------------------MENU PORTION------------------
            { path: '/frontMenu', name: 'frontMenu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/backend/Website/Menu/Index'), beforeEnter: authGuard },
            { path: '/frontMenu/create', name: 'frontMenu.create', component: () => import('./../views/backend/Website/Menu/Create'), beforeEnter: authGuard },
            { path: '/frontMenu/:id', name: 'frontMenu.show', component: () => import('./../views/backend/Website/Menu/View'), beforeEnter: authGuard },
            { path: '/frontMenu/:id/edit', name: 'frontMenu.edit', component: () => import('./../views/backend/Website/Menu/Create'), beforeEnter: authGuard },
            // ------------------CONTENT PORTION------------------
            { path: '/content/:slug', name: 'content.show', component: () => import('./../views/backend/Website/Content/View'), beforeEnter: authGuard },
            { path: '/content/:slug/create', name: 'content.create', component: () => import('./../views/backend/Website/Content/Create'), beforeEnter: authGuard },
            { path: '/content-file/:slug', name: 'content.file', component: () => import('./../views/backend/Website/Content/CreateFile'), beforeEnter: authGuard },
            // ------------------SLIDER PORTION------------------
            { path: '/slider', name: 'slider.index', meta: { title: 'Slider', nav: true }, component: () => import('./../views/backend/Website/Gallery/Slider/Index'), beforeEnter: authGuard },
            { path: '/slider/create', name: 'slider.create', component: () => import('./../views/backend/Website/Gallery/Slider/Create'), beforeEnter: authGuard },
            { path: '/slider/:id', name: 'slider.show', component: () => import('./../views/backend/Website/Gallery/Slider/View'), beforeEnter: authGuard },
            { path: '/slider/:id/edit', name: 'slider.edit', component: () => import('./../views/backend/Website/Gallery/Slider/Create'), beforeEnter: authGuard },
            // ------------------ALBUM PORTION------------------
            { path: '/album', name: 'album.index', meta: { title: 'Album', nav: true }, component: () => import('./../views/backend/Website/Gallery/Album/Index'), beforeEnter: authGuard },
            { path: '/album/create', name: 'album.create', component: () => import('./../views/backend/Website/Gallery/Album/Create'), beforeEnter: authGuard },
            { path: '/album/:id', name: 'album.show', component: () => import('./../views/backend/Website/Gallery/Album/View'), beforeEnter: authGuard },
            { path: '/album/:id/edit', name: 'album.edit', component: () => import('./../views/backend/Website/Gallery/Album/Create'), beforeEnter: authGuard },
            // ------------------PHOTO PORTION------------------
            { path: '/photo', name: 'photo.index', meta: { title: 'Photo', nav: true }, component: () => import('./../views/backend/Website/Gallery/Photo/Index'), beforeEnter: authGuard },
            { path: '/photo/create', name: 'photo.create', component: () => import('./../views/backend/Website/Gallery/Photo/Create'), beforeEnter: authGuard },
            { path: '/photo/:id', name: 'photo.show', component: () => import('./../views/backend/Website/Gallery/Photo/View'), beforeEnter: authGuard },
            { path: '/photo/:id/edit', name: 'photo.edit', component: () => import('./../views/backend/Website/Gallery/Photo/Create'), beforeEnter: authGuard },
            // ------------------VIDEO PORTION------------------
            { path: '/video', name: 'video.index', meta: { title: 'Video', nav: true }, component: () => import('./../views/backend/Website/Gallery/Video/Index'), beforeEnter: authGuard },
            { path: '/video/create', name: 'video.create', component: () => import('./../views/backend/Website/Gallery/Video/Create'), beforeEnter: authGuard },
            { path: '/video/:id', name: 'video.show', component: () => import('./../views/backend/Website/Gallery/Video/View'), beforeEnter: authGuard },
            { path: '/video/:id/edit', name: 'video.edit', component: () => import('./../views/backend/Website/Gallery/Video/Create'), beforeEnter: authGuard },
            // ------------------News portion------------------
            { path: '/news', name: 'news.index', meta: { title: 'News', nav: true }, component: () => import('./../views/backend/Website/News/Index'), beforeEnter: authGuard },
            { path: '/news/create', name: 'news.create', component: () => import('./../views/backend/Website/News/Create'), beforeEnter: authGuard },
            { path: '/news/:id', name: 'news.show', component: () => import('./../views/backend/Website/News/View'), beforeEnter: authGuard },
            { path: '/news/:id/edit', name: 'news.edit', component: () => import('./../views/backend/Website/News/Create'), beforeEnter: authGuard },
            // ------------------USER PORTION------------------
            { path: '/user', name: 'user.index', meta: { title: 'User', nav: true }, component: () => import('./../views/backend/User/Index'), beforeEnter: authGuard },
            { path: '/user/create', name: 'user.create', component: () => import('./../views/backend/User/Create'), beforeEnter: authGuard },
            { path: '/user/:id', name: 'user.show', component: () => import('./../views/backend/User/View'), beforeEnter: authGuard },
            { path: '/user/:id/edit', name: 'user.edit', component: () => import('./../views/backend/User/Create'), beforeEnter: authGuard },

            // ------------------ACCOUNTHEAD PORTION------------------
            { path: '/accountHead', name: 'accountHead.index', meta: { title: 'AccountHead', nav: true }, component: () => import('./../views/backend/MasterSetup/AccountHead/Index'), beforeEnter: authGuard },
            { path: '/accountHead/create', name: 'accountHead.create', component: () => import('./../views/backend/MasterSetup/AccountHead/Create'), beforeEnter: authGuard },
            { path: '/accountHead/:id', name: 'accountHead.show', component: () => import('./../views/backend/MasterSetup/AccountHead/View'), beforeEnter: authGuard },
            { path: '/accountHead/:id/edit', name: 'accountHead.edit', component: () => import('./../views/backend/MasterSetup/AccountHead/Create'), beforeEnter: authGuard },
            // ------------------INVOICE PORTION------------------
            { path: '/invoice', name: 'invoice.index', meta: { title: 'Invoice', nav: true }, component: () => import('./../views/backend/Invoice/Index'), beforeEnter: authGuard },
            { path: '/invoice/create', name: 'invoice.create', component: () => import('./../views/backend/Invoice/Create'), beforeEnter: authGuard },
            { path: '/invoice/:id', name: 'invoice.show', component: () => import('./../views/backend/Invoice/View'), beforeEnter: authGuard },
            { path: '/invoice/:id/edit', name: 'invoice.edit', component: () => import('./../views/backend/Invoice/Create'), beforeEnter: authGuard },

            // ------------------ADMIN PORTION------------------
            { path: '/dashboard', name: 'admin.dashboard', meta: { title: 'Dashboard', nav: true }, component: () => import('./../views/backend/Admin/Dashboard'), beforeEnter: authGuard },
            { path: '/sitemap', name: 'admin.sitemap', component: () => import('./../views/backend/Admin/Sitemap'), beforeEnter: authGuard },
            { path: '/admin', name: 'admin.index', meta: { title: 'Admin', nav: true }, component: () => import('./../views/backend/Admin/Index'), beforeEnter: authGuard },
            { path: '/admin/create', name: 'admin.create', component: () => import('./../views/backend/Admin/Create'), beforeEnter: authGuard },
            { path: '/admin/:id', name: 'admin.show', component: () => import('./../views/backend/Admin/View'), beforeEnter: authGuard },
            { path: '/admin/:id/edit', name: 'admin.edit', component: () => import('./../views/backend/Admin/Create'), beforeEnter: authGuard },
            // ------------------ROLE PORTION------------------
            { path: '/role', name: 'role.index', meta: { title: 'Role', nav: true }, component: () => import('./../views/backend/System/Role/Index'), beforeEnter: authGuard },
            { path: '/role/create', name: 'role.create', component: () => import('./../views/backend/System/Role/Create'), beforeEnter: authGuard },
            { path: '/role/:id', name: 'role.show', component: () => import('./../views/backend/System/Role/View'), beforeEnter: authGuard },
            { path: '/role/:id/edit', name: 'role.edit', component: () => import('./../views/backend/System/Role/Create'), beforeEnter: authGuard },
            // ------------------MENU PORTION------------------
            { path: '/menu', name: 'menu.index', meta: { title: 'Menu', nav: true }, component: () => import('./../views/backend/System/Menu/Index'), beforeEnter: authGuard },
            { path: '/menu/create', name: 'menu.create', component: () => import('./../views/backend/System/Menu/Create'), beforeEnter: authGuard },
            { path: '/menu/:id', name: 'menu.show', component: () => import('./../views/backend/System/Menu/View'), beforeEnter: authGuard },
            { path: '/menu/:id/edit', name: 'menu.edit', component: () => import('./../views/backend/System/Menu/Create'), beforeEnter: authGuard },
            // ------------------SITE SETTING PORTION------------------
            { path: '/siteSetting', name: 'siteSetting.index', meta: { title: 'Site Settings', nav: true }, component: () => import('./../views/backend/System/SiteSettings/Index'), beforeEnter: authGuard },
            { path: '/siteSetting/create', name: 'siteSetting.create', component: () => import('./../views/backend/System/SiteSettings/Create'), beforeEnter: authGuard },
            { path: '/siteSetting/:id', name: 'siteSetting.show', component: () => import('./../views/backend/System/SiteSettings/View'), beforeEnter: authGuard },
            { path: '/siteSetting/:id/edit', name: 'siteSetting.edit', component: () => import('./../views/backend/System/SiteSettings/Create'), beforeEnter: authGuard },
            // ------------------MODULE PORTION------------------
            { path: '/module', name: 'module.index', component: () => import('./../views/backend/System/Module/Index'), beforeEnter: authGuard },
            { path: '/module/create', name: 'module.create', component: () => import('./../views/backend/System/Module/Create'), beforeEnter: authGuard },
            // ------------------ACTIVITY LOG PORTION------------------
            { path: '/activityLog', name: 'activityLog.index', meta: { title: 'Activity Log', nav: true }, component: () => import('./../views/backend/System/ActivityLog/Index'), beforeEnter: authGuard },
            { path: '/activityLog/:id', name: 'activityLog.show', component: () => import('./../views/backend/System/ActivityLog/View'), beforeEnter: authGuard },
        
            { path: '/test', name: 'test.index', meta: { title: 'Test', nav: true }, component: () => import('./../views/backend/Test/Index'), beforeEnter: authGuard },
            { path: '/test/create', name: 'test.create', component: () => import('./../views/backend/Test/Create'), beforeEnter: authGuard },
            { path: '/test/:id', name: 'test.show', component: () => import('./../views/backend/Test/View'), beforeEnter: authGuard },
            { path: '/test/:id/edit', name: 'test.edit', component: () => import('./../views/backend/Test/Create'), beforeEnter: authGuard },
        ]
    },

    // if any component or view not found then showing 404 page
    {
        path: '*', component: () => import('./../views/backend/NotFoundLayout'), beforeEnter: authGuard,
        children: [
            { path: '*', name: '404', component: () => import('./../views/errors/404'), beforeEnter: authGuard }
        ]
    }
];



// ========== define router==========
const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history',
    base: process.env.MIX_VUE_ROUTER_BASE + '/admin/',
    linkExactActiveClass: "active",
    scrollBehavior() {
        return { x: 0, y: 0 };
    }
})

// ==========check login or not==========
function authGuard(to, from, next) {
    if (Admin.loggedIn()) {
        if (to.meta.nav) {
            const obj = { 'route': to.name, 'title': to.meta.title ? to.meta.title : to.name }
            breadcrumbs.dispatch("addMenu", obj);
        }
        next();
    } else {
        next({ name: 'admin.loginme' });
    }
}

export default router
