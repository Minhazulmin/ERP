<template>
    <header class="main-header">
        <!-- Logo -->
        <!--    <a href="#" class="logo">-->
        <!--      &lt;!&ndash; mini logo for sidebar mini 50x50 pixels &ndash;&gt;-->
        <!--      <span class="logo-mini"> {{$root.site?$root.site.short_title:''}} </span>-->
        <!--      &lt;!&ndash; logo for regular state and mobile devices &ndash;&gt;-->
        <!--      <span class="logo-lg"> {{$root.site?$root.site.title:''}} </span>-->
        <!--    </a>-->
        <!-- Header Navbar: style can be found in header.less -->
        <!-- <nav class="navbar navbar-expand-md navbar-light bg-light"> -->
        <nav class="navbar navbar-expand-md" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div id="navbarCollapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav ml-auto">
                    <li class="nav-item dropdown messages-menu">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-danger text-light">4</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img
                                                    :src="$root.userimage"
                                                    class="img-circle"
                                                    alt="User Image"
                                                />
                                            </div>
                                            <h4>
                                                Support Team
                                                <small> <i class="fa fa-clock-o"></i> 5 mins </small>
                                            </h4>
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">See All Messages</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown notifications-menu">
                        <a href="#" class="nav-link" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-danger text-light">10</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined
                                            today
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown user user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                            <img
                                :src="profileImage ? profileImage : $root.userimage"
                                class="user-image"
                                alt="User Image"
                            />
                            <span class="hidden-xs">{{ logged_name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right bg-transparent border-0">
                            <div
                                class="css-pjw283-MuiPaper-root-MuiPopover-paper"
                                tabindex="-1"
                                style="opacity: 1; transform: none; transition: opacity 301ms cubic-bezier(0.4, 0, 0.2, 1) 0ms, transform 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; top: 68px; left: 1239px; transform-origin: 220px 0px;">
                                <span class="arrow css-1uz16b9"></span>
                                <div class="MuiBox-root css-1sz2mvt">
                                    <div class="image">
                                        <img
                                            :src="profileImage ? profileImage : $root.userimage"
                                            class="img-circle"
                                            alt="User Image"
                                        />
                                    </div>
                                    <h5> {{ logged_name }}
                                        <small class="text-muted">{{ role_name }}</small>
                                    </h5>
                                </div>
                                <hr class="css-ifwvxx-MuiDivider-root">
                                <router-link to="/dashboard" class="item-button"> <i class="bi bi-cast"></i>  Dashboard</router-link>
                                <router-link :to="{ name: 'admin.show', params: { id: logged_id } }" class="item-button" >
                                    <i class="bi bi-person-fill"></i>  Profile
                                </router-link>
                                <router-link :to="{ name: 'admin.show', params: { id: logged_id } }" class="item-button">
                                    <i class="bi bi-gear-fill"></i>  Settings
                                </router-link>
                                <div class="MuiBox-root css-r35rip">
                                    <button @click="Logout()"  class="logout-button">
                                        Logout
                                    </button>
                                </div>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
export default {
    data() {
        return {
            role_name: "",
            logged_id: "",
            logged_name: "",
        };
    },
    computed: {
        profileImage() {
            return profile.state.image;
        },
    },
    methods: {
        Logout() {
            this.$root.spinner = true;
            Admin.logout();
        },
    },
    created() {
        this.logged_id = Admin.id();
        this.role_name = Admin.role();
        this.logged_name = Admin.name();
    },
};
</script>

<style>
.navbar {
    height: 50px !important;
}
</style>
