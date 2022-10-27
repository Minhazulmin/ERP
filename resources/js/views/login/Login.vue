<template>
  <div class="container">
    <div class="screen">
      <div class="screen__content">
          <div class="long-icon">
              <i class="bi bi-person-fill"></i>
          </div>
        <slot v-if="!$root.spinner">
            <h3 class="admin-login">Admin Login</h3>
          <form v-on:submit.prevent="submit" method="post" class="login">
            <div class="login__field">
              <i class="login__icon bi bi-person-fill"></i>
              <input
                type="text"
                class="login__input"
                v-model="data.email"
                placeholder="User name / Email"
              />
              <div class="text-danger">
                {{ validation.firstError("data.email") }}
              </div>
            </div>
            <div class="login__field">
              <i class="login__icon bi bi-lock-fill"></i>
              <input
                :type="passwordIstext ? 'text' :'password'"
                v-model="data.password"
                class="login__input"
                placeholder="Password"
              />
                <a href="javascript:void(0)" class="see-password" @click="passwordIstext = ! passwordIstext">
                    <i class="bi bi-eye-slash" v-if="!passwordIstext"></i>
                    <i class="bi bi-eye" v-else></i>
                </a>
              <div class="text-danger">
                {{ validation.firstError("data.password") }}
              </div>
            </div>
            <button type="submit" class="button login__submit">
              <span class="button__text">Log In</span>
              <i class="button__icon fa fa-angle-right"></i>
            </button></form
        ></slot>
        <div v-if="$root.spinner" class="login mt-3">
          <spinner />
        </div>
      </div>
<!--      <div class="screen__background">-->
<!--        <span-->
<!--          class="screen__background__shape screen__background__shape4"-->
<!--        ></span>-->
<!--        <span-->
<!--          class="screen__background__shape screen__background__shape3"-->
<!--        ></span>-->
<!--        <span-->
<!--          class="screen__background__shape screen__background__shape2"-->
<!--        ></span>-->
<!--        <span-->
<!--          class="screen__background__shape screen__background__shape1"-->
<!--        ></span>-->
<!--      </div>-->
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
        passwordIstext:false,
      data: {
        email: "oshitsd@gmail.com",
        password: "oshitsd",
      },
    };
  },
  methods: {
    submit() {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        if (res) {
          this.$root.spinner = true;
          axios
            .post("/login-admin", this.data)
            .then((res) => {
              if (res.status == 200 && res.data.id) {
                Admin.login(res.data);
                this.notification(res.data.message, "success");
                window.location = this.$root.baseurl + "/admin/dashboard";
              } else {
                this.$root.spinner = false;
                this.notification(res.data.message, "error");
              }
            })
            .catch((error) => {
              this.$root.spinner = false;
              this.notification(
                "Something went wrong, please try again",
                "error"
              );
            });
        }
      });
    },
  },
  created() {
    $(".body").removeClass("hold-transition skin-blue sidebar-mini");
    $(".body").addClass("hold-transition login-page");
  },

  // ================== validation rule for form ==================
  validators: {
    "data.email": function (value = null) {
      return Validator.value(value).required("Email is required");
    },
    "data.password": function (value = null) {
      return Validator.value(value)
        .required("Password is required")
        .minLength(6);
    },
  },
};
</script>
