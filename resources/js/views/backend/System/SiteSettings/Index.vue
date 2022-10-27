<template>
  <div>
    <div class="box box-success" v-if="!$root.spinner">
      <div class="box-header with-border">
        <div class="row">
          <form v-on:submit.prevent="search" class="row col-12 ml-0">
            <!--============ Search Option Start ============-->
            <Search :fields_name="fields_name" />
            <!--============ Search Option End ============-->
          </form>
        </div>

        <!--============ Add or Back Button Start ============-->
        <div class="box-tools pull-right">
          <router-link
            v-if="$root.checkPermission(model + '.create')"
            :to="{ name: model + '.create' }"
            class="btn btn-xs btn-success pull-left text-white"
            title="Add New"
          >
            <i class="fa fa-plus"></i>
            Add Site Settings
          </router-link>
        </div>
        <!--============ Add or Back Button End ============-->
      </div>

      <!--============ Data List Start ============-->
      <div class="box-body box-min-height">
        <base-table
          :data="table.datas"
          :columns="table.columns"
          :routes="table.routes"
          thead-classes="bg-light text-secondary"
        ></base-table>
      </div>
      <!--============ Data List End ============-->

      <div class="box-footer clearfix">
        <!--============ Pagination Start ============-->
        <Pagination
          :url="model"
          v-if="!$root.spinner"
          :search_data="search_data"
        />
        <!--============ Pagination End ============-->
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "siteSetting";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "title", title: "Title" },
  { field: "short_title", title: "Short Title" },
  {
    field: "logo",
    title: "Logo",
    image: true,
    imgWidth: "50px",
    height: "50px",
  },
  { field: "contact_email", title: "Contact Email" },
];

//json fields for export excel
const json_fields = {
  Title: "title",
  "Short Title": "short_title",
  Logo: "logo",
  Email: "email",
  Mobile: "mobile",
  Address: "address",
  Logo: "logo",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: { 0: "Select One", name: "Name" },
      search_data: {
        pagination: 10,
        field_name: 0,
        value: "",
      },
      table: {
        columns: tableColumns,
        routes: {},
        datas: [],
        meta: [],
        links: [],
      },
    };
  },
  methods: {
    destroy(id) {
      this.destroy_data(this.model, id, this.search_data);
    },
    search() {
      this.get_paginate_data(this.model, this.search_data);
    },
  },
  created() {
    this.get_paginate_data(this.model, this.search_data);
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index", "Site Setting");
  },
};
</script>