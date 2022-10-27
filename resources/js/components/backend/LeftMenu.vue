<template>
  <aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="image">
          <img :src="$root.baseurl + '/images/company-logo.png'" alt="" />
          <h3 class="text-light">GOOGLE ADWORDS</h3>
        </div>
      </div>
      <ul
        v-if="$root.menus && Object.keys($root.menus).length > 0"
        class="sidebar-menu"
      >
        <li>
          <router-link :to="{ name: 'admin.dashboard' }">
            <i class="bi bi-cast"></i> <span>Dashboard</span>
          </router-link>
        </li>

        <slot v-for="(root_menu, index) in $root.menus">
          <!-- ===================CHILDREN MENU=================== -->
          <slot
            v-if="
              root_menu.child_menus &&
              Object.keys(root_menu.child_menus).length > 0
            "
          >
            <li :key="index" class="treeview">
              <a href="javascript:void(0)">
                <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                <span>{{ root_menu.menu_name }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <RecursiveMenu
                :key="index + 'A'"
                :root_menu="root_menu.menu_name"
                :child_menus="root_menu.child_menus"
              />
            </li>
          </slot>
          <!-- ===================CHILDREN MENU=================== -->

          <slot v-else>
            <li
              :key="index"
              v-if="
                root_menu.route_name &&
                $root.checkPermission(root_menu.route_name)
              "
              :class="
                $route.name == root_menu.route_name
                  ? 'active menu-activated'
                  : ''
              "
            >
              <!-- MENU  WITH PARAMS-->
              <router-link
                v-if="root_menu.params"
                :to="{
                  name: root_menu.route_name,
                  params: { slug: root_menu.params },
                }"
              >
                <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                <span>{{ root_menu.menu_name }}</span>
              </router-link>

              <!-- SINGLE MENU -->
              <router-link v-else :to="{ name: root_menu.route_name }">
                <em v-if="root_menu.icon" v-html="root_menu.icon"></em>
                <span>{{ root_menu.menu_name }}</span>
              </router-link>
            </li>
          </slot>
        </slot>
        <li>
          <router-link :to="{ name: 'admin.sitemap' }">
            <i class="fa fa-map"></i> <span>Site Map</span>
          </router-link>
        </li>
      </ul>
    </section>
    <div class="footer">
      <a href="">
        <h4>
          <img :src="$root.baseurl + '/images/nogor-logo.png'" alt="" /> Nogor
          Solutions ltd.
          <img
            :src="$root.baseurl + '/images/developby.png'"
            alt=""
            style="width: 3em;position: relative; top: -2px;}"
          />
        </h4>
      </a>
    </div>
  </aside>
</template>

<script>
import RecursiveMenu from "./LeftMenuRecursive";

export default {
  components: {
    RecursiveMenu,
  },
  data() {
    return {
      logged_id: "",
      logged_name: "",
    };
  },
  computed: {
    profileImage() {
      return profile.state.image;
    },
  },
  created() {
    this.logged_id = Admin.id();
    this.logged_name = Admin.name();

    $(document).ready(function () {
      $(".sidebar-menu").tree();
    });
  },
  updated() {
    $(document).ready(function () {
      $(".sidebar-menu").tree();
    });
  },
};
</script>

<style lang="scss">
.user-panel {
  .info ul {
    list-style: none;
    margin: 0px 32px;
    padding: 0;

    li {
      a {
        i {
          font-size: 15px;
          color: #ffffffc7;
        }
        span {
          font-size: 7px;
          position: relative;
          left: -6px;
          top: -6px;
        }
      }
    }
  }
}
.footer {
  position: absolute;
  bottom: 0;
  background: #f8f9fa;
  width: 100%;
  height: 40px;
  padding: 5px;
  text-align: center;
  border-top: 2px solid #0406098f;
  h4 {
    font-size: 15px;
    color: #000000;
  }
}
.sidebar-mini.sidebar-collapse .main-sidebar {
  .user-panel > .image > img {
    height: 40px;
    width: 40px;
    border-radius: 50px;
  }
  .user-panel > .image > h3 {
    display: none;
  }
}
</style>
