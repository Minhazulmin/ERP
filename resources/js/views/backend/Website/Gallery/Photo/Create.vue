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
            <Select
              v-if="albums"
              title="Album"
              field="album_id"
              :req="true"
              :datas="albums"
            />
            <!------------ Single Input ------------>
            <Input
              title="Title"
              field="title"
              type="text"
              col="4"
              :req="true"
            />
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
              :width="700"
              :height="600"
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
const model = "photo";

export default {
  data() {
    return {
      model: model,
      data: { album_id: "", image: "", sorting: 0 },
      image: { image: "" },
      albums: {},
      errors: {},
    };
  },
  methods: {
    submit: function () {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
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
    getAlbum() {
      axios.get("/get-album/Photos").then((res) => (this.albums = res.data));
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(this.model, this.$route.params.id, "data"); // get data for edit
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Website-Gallery-Photo");
    }
    this.getAlbum();
  },

  // ================== validation rule for form ==================
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.image": function (value = null) {
      return Validator.value(value).required("Image is required");
    },
    "data.album_id": function (value = null) {
      return Validator.value(value).required("Album is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>