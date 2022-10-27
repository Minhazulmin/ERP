<template>
  <div>
    <div class="box box-success" v-if="!$root.spinner">
      <div class="box-header with-border">
        <h3 class="box-title">{{ model + " Create" }}</h3>

        <!--============ Add or Back Button Start ============-->
        <AddOrBackButton
          :route="model + '.index'"
          :portion="model"
          :icon="'arrow-left'"
        />
        <!--============ Add or Back Button End ============-->
      </div>

      <div class="box-body box-min-height">
        <!--============ Form Start ============-->
        <div class="row">
          <form
            v-on:submit.prevent="submit"
            enctype="multipart/form-data"
            id="form"
            class="form-row col-12"
          >
            <!------------ Single Input ------------>
            <Radio
              title="Type"
              field="type"
              statusTitle1="Photos"
              statusTitle2="Videos"
              value1="Photos"
              value2="Videos"
              :req="true"
              col="2"
            />
            <!------------ Single Input ------------>
            <Input title="Name" field="name" type="text" :req="true" />
            <!------------ Single Input ------------>
            <File
              title="Image"
              field="image"
              mime="img"
              :req="true"
              fileClassName="file1"
              :crop="true"
            />
            <!-- FOR CROP IMAGE -->
            <Crop
              field="image"
              :image="image.image"
              :aspectRatio="{ aspectRatio: 1 }"
              :width="250"
              :height="250"
            />

            <!------------ Single Input ------------>
            <Input
              title="Sorting"
              field="sorting"
              type="text"
              :req="true"
              col="2"
            />

            <!-------------- button -------------->
            <div class="col-12 mb-3 mt-2">
              <Button title="Submit" process="" />
            </div>
            <!-------------- button -------------->
          </form>
        </div>
        <!--============ Form End ============-->
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "album";

export default {
  data() {
    return {
      model: model,
      exist: false,
      data: { type: "Photos", image: "", sorting: 0 },
      image: { image: "" },
      errors: {},
    };
  },
  methods: {
    submit: function () {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        // If there is an error
        if (error > 0) {
          this.notification(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        // If there is no error
        if (res) {
          if (this.data.slug) {
            this.update(this.model, this.data, this.data.slug);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(this.model, this.$route.params.id, "data");
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Website-Gallery-Album");
    }
  },

  // ================== validation rule for form ==================
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.image": function (value = null) {
      if (!value.type) {
        return false;
      }
      return Validator.value(value)
        .required("Image is required")
        .custom(function () {
          if (!Validator.isEmpty(value)) {
            var type = value.type;
            if (
              type == "image/jpeg" ||
              type == "image/jpg" ||
              type == "image/png"
            ) {
            } else {
              return "Image must be of type .jpg .jpeg or .png";
            }
          }
        });
    },
  },
};
</script>