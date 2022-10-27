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
            <Input title="Title" field="title" type="text" :req="true" />
            <!------------ Single Input ------------>
            <File
              title="Slider"
              field="slider"
              mime="img"
              :req="true"
              fileClassName="file1"
              :crop="true"
            />
            <!-- FOR CROP IMAGE -->
            <Crop
              field="slider"
              :image="image.slider"
              :aspectRatio="{ aspectRatio: 18 / 6 }"
              :width="900"
              :height="300"
            />

            <!------------ Single Input ------------>
            <Input
              title="Sorting"
              field="sorting"
              type="text"
              :req="true"
              col="2"
            />
            <!------------ Single Input ------------>
            <Input title="URL" field="url" type="url" :req="false" col="4" />

            <!------------ Single Input ------------>
            <div class="form-row col-12">
              <label class="col-12">Description</label>
              <div class="col-12">
                <editor :editorModel="'description'" />
              </div>
            </div>

            <!-------------- button -------------->
            <div class="col-12 mb-3 mt-3">
              <Button title="Submit" process="" />
            </div>
            <!-------------- button -------------->
          </form>
        </div>
        <!--============ Form End ============-->
      </div>
    </div>
    <pre>
      {{ data }}
    </pre>
  </div>
</template>

<script>
// define model name
const model = "slider";

export default {
  data() {
    return {
      model: model,
      image: { slider: "" },
      data: { slider: "", sorting: "" },
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
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id);
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
      this.get_sorting("Website-Gallery-Slider");
    }
  },

  // ================== validation rule for form ==================
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.slider": function (value = null) {
      return Validator.value(value).required("Slider is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>