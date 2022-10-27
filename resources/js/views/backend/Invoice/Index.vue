<template>
  <div>
    <div class="box box-success">
      <div class="box-header with-border">
        <div class="row">
          <form v-on:submit.prevent="search" class="row col-12 ml-0">
            <!--============ Search Option Start ============-->
            <Search :fields_name="fields_name" />
            <!--============ Search Option End ============-->
          </form>
        </div>

        <!--============ Add or Back Button Start ============-->
        <AddOrBackButton
          :route="model + '.create'"
          :portion="model"
          :icon="'plus'"
          title="Payment History"
        />
        <!--============ Add or Back Button End ============-->
      </div>

      <!--============ Data List Start ============-->
      <div class="box-body box-min-height">
        <base-table
          :data="table.datas"
          :columns="table.columns"
          :routes="table.routes"
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
const model = "invoice";

// define table coloumn show in datatable / datalist
const tableColumns = [
  { field: "invoice_date", title: "Date", date: true },
  { field: "member", title: "Member Name", subfield: "name" },
  { field: "user", title: "User Name", subfield: "name" },
  { field: "invoice_number", title: "Invoice Number", align: "center" },
  { field: "head", title: "Purpose", subfield: "name", align: "center" },
  { field: "amount", title: "Amount", align: "center" },
  { field: "payment_date", title: "Payment Date", date: true },
  { field: "status", title: "Status", align: "center" },
];
//json fields for export excel
const json_fields = {
  Name: "name",
  "Created at": "created_at",
};

export default {
  data() {
    return {
      model: model,
      json_fields: json_fields,
      fields_name: {
        0: "Select One",
        invoice_number: "Invoice Number",
      },
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
      this.$route.query.page = "";
      this.get_paginate_data(this.model, this.search_data);
    },
  },
  async created() {
    await this.get_paginate_data(this.model, this.search_data);
    this.getRouteName(this.model);
    this.setBreadcrumbs(this.model, "index", "Payment History");
  },
};
</script>