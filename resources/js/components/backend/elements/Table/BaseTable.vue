<template>
    <div>
        <!-- ================Excel , PDF, Print Button================ -->
        <div class="box-header no-padding epp-content">
            <select
                @change="$parent.search"
                v-model="$parent.search_data.pagination"
                class="form-control form-control-sm paginate"
            >
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
                <option>200</option>
                <option>500</option>
                <option value="9999">All</option>
            </select>
            <div class="box-tools pull-right">
                <!-- print -->
                <a v-b-tooltip.hover title="Print"
                    href="javascript:void(0)"
                    class="btn-custom printer"
                    @click="print('printArea', $parent.model)"
                >
                    <img  :src="$root.baseurl + '/images/printer.png'" alt="">
                </a>
                <!-- /print -->
                <!-- PDF -->
                <a v-b-tooltip.hover title="Download PDF"
                    href="javascript:void(0)"
                    class="btn-custom pdf"
                    @click="generatePdf"
                >
                    <img  :src="$root.baseurl + '/images/pdf.png'" alt="">
                </a>
                <!-- /pdf -->
                <!-- Excel -->
                <download-excel
                    v-b-tooltip.hover title="Export as Excel"
                    v-if="$parent.table.datas"
                    class="btn-custom excel"
                    :data="$parent.table.datas"
                    :fields="$parent.json_fields"
                    :name="$parent.model + '.xls'"
                >
                    <img  :src="$root.baseurl + '/images/excel.png'" alt="">
                </download-excel>
                <!-- Excel -->
            </div>
        </div>
        <!-- ================Excel , PDF, Print Button================ -->

        <div class="col-12 no-padding" id="printArea">
            <div class="table-responsive  b-table-sticky-header" style="max-height: 500px; min-height: 500px;">
                <table
                    id="pdf-table"
                    class="table table-bordered table-hover table-striped-custom b-table"
                    border="1"
                >
                    <thead class="base-table-thead">
                    <tr>
                        <th class="sl text-center">#</th>
                        <slot name="columns">
                            <th
                                v-for="(column, index) in columns"
                                :key="'a' + index"
                                @click="sort(column.field)"
                                class="sort-th"
                                :style="'text-align:' + column.align + '; width:' + column.width"
                            >
                                {{ column.title }}
                                <slot v-if="!column.subfield">
                                    <span v-if="coloumSort == column.field">
                                      <i style="color: #673ab7;"
                                          v-if="order == 'desc'"
                                          class="fa fa-sort-up pull-right sort"
                                      ></i>
                                      <i style="color: #673ab7;"
                                          v-if="order == 'asc'"
                                          class="fa fa-sort-down pull-right sort"
                                      ></i>
                                    </span>
                                    <i v-else class="fa fa-sort pull-right sort"></i>
                                </slot>
                            </th>

                            <th width="5%"
                                v-if="
                    Object.keys(routes).length > 0 &&
                    ($root.checkPermission(routes.view) ||
                      $root.checkPermission(routes.edit) ||
                      $root.checkPermission(routes.destroy))
                  "
                                :class="routes.array ? 'action-extra' : 'action'"
                            >
                                <i class="bi bi-gear"></i>
                            </th>
                        </slot>
                    </tr>
                    </thead>
                    <slot v-if="!$root.tableSpinner">
                        <tbody v-if="Object.keys(data).length > 0">
                        <tr
                            v-for="(item, index) in data"
                            :key="index"
                            class="change_sorting"
                            :class="
                  'change_sorting' + item.sorting + ' update_item' + item.id
                "
                        >
                            <td class="text-center" v-if="$parent.table.meta">
                                {{ $parent.table.meta.from + index }}
                            </td>
                            <td v-else class="text-center">{{ index + 1 }}</td>
                            <slot :row="item">
                                <slot v-for="(column, index) in columns">
                                    <td class="position-relative"
                                        :key="'b' + index"
                                        :style="'text-align:' + column.align"
                                        :v-if="hasValue(item, column.field)"
                                        >
                                      <span v-if="column.date">{{
                                              itemValue(item, column.field, column.subfield)
                                                  | formatDate
                                          }}</span>
                                        <span v-else-if="column.array">{{
                                                column.array_value[0][
                                                    itemValue(item, column.field, column.subfield)
                                                    ]
                                            }}</span>
                                        <slot v-else-if="column.sorting">
                                            <input
                                                v-if="!sorting_spin"
                                                v-on:keyup.enter="
                                                    tableSorting(
                                                      $event.target.value,
                                                      item.id,
                                                      column.namespace,
                                                      column.auto
                                                    )
                                                  "
                                                :value="item[column.field]"
                                                type="number"
                                                class="base-table-form-control text-center"
                                                style="width: 30px; font-size: 12px"
                                                :id="item.id"
                                            />

                                            <i v-if="item.id == sorting_spin"
                                                class="fa fa-spinner fa-spin mt-2 ml-2 text-primary"
                                            ></i>
                                            <label v-else :for="item.id" class="change-sorting" v-b-tooltip title="Click to change sorting">
                                                <i class="fa fa-pencil"></i>
                                            </label>
                                        </slot>
                                        <img
                                            v-else-if="
                          column.image &&
                          itemValue(item, column.field, column.subfield)
                        "
                                            :src="itemValue(item, column.field, column.subfield)"
                                            :style="
                          'width:' +
                          column.imgWidth +
                          ';height:' +
                          column.height
                        "
                                        />
                                        <span v-else-if="column.field == 'status'">
                        <span
                            class="badge bg-green"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                              'active' ||
                            itemValue(item, column.field, column.subfield) == 1
                          "
                        >ACTIVE</span
                        >
                        <span
                            class="badge bg-red"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                              'deactive' ||
                            itemValue(item, column.field, column.subfield) == 0
                          "
                        >DEACTIVE</span
                        >
                        <span
                            class="badge bg-red"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'ur'
                          "
                        >UNREAD</span
                        >
                        <span
                            class="badge bg-green"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'r'
                          "
                        >READ</span
                        >
                        <span
                            class="badge bg-red"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'pending'
                          "
                        >PENDING</span
                        >
                        <span
                            class="badge bg-green"
                            v-if="
                            itemValue(item, column.field, column.subfield) ==
                            'success'
                          "
                        >SUCCESS</span
                        >
                      </span>
                                        <span v-else>{{
                                                itemValue(item, column.field, column.subfield)
                                            }}</span>
                                    </td>
                                </slot>
                                <td
                                    v-if="
                      Object.keys(routes).length > 0 &&
                      ($root.checkPermission(routes.view) ||
                        $root.checkPermission(routes.edit) ||
                        $root.checkPermission(routes.destroy))
                    "
                                    :class="routes.array ? 'action-extra' : 'action'"
                                >
                                    <div class="btn-group dropleft">
                                        <a href="javascript:void(0)" class="more-menu" v-b-tooltip title="Click to more option" data-toggle="dropdown" aria-haspopup="true"
                                           aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu" style="box-shadow: 0px 0px 20px 10px #4444441a;">
                                            <router-link
                                                v-if="routes.view && $root.checkPermission(routes.view)"
                                                :to="{
                                                    name: routes.view,
                                                    params: { id: item.slug ? item.slug : item.id },
                                                    query: { page: $route.query.page },
                      }"
                                                        class="action-view dropdown-item"
                                                        title="View">
                                                <i class="fa fa-eye"></i> View
                                            </router-link>

                                            <router-link
                                                v-if="routes.edit && $root.checkPermission(routes.edit)"
                                                :to="{
                        name: routes.edit,
                        params: { id: item.slug ? item.slug : item.id },
                        query: { page: $route.query.page },
                      }"
                                                class="action-pencil dropdown-item"
                                                title="Edit"
                                            >
                                                <i class="fa fa-pencil"></i> Edit
                                            </router-link>

                                            <button
                                                v-if="
                        routes.destroy && $root.checkPermission(routes.destroy)
                      "
                                                v-on:click="destroy(item.slug ? item.slug : item.id)"
                                                class="action-trash dropdown-item"
                                                title="Delete"
                                            >
                                                <i class="fa fa-trash"></i> Delete
                                            </button>

                                            <!-- custom route -->
                                            <slot v-if="routes.array">
                                                <slot v-for="(rt, index) in routes.array">
                                                    <router-link
                                                        :key="index"
                                                        v-if="rt.route && $root.checkPermission(rt.route)"
                                                        :to="{ name: rt.route, params: { id: item.slug ? item.slug : item.id },}"
                                                        :class="'btn btn-xs btn-' + rt.btnColor"
                                                        class="action-custom"
                                                    >
                                                        <i :class="'fa fa-' + rt.icon"></i>
                                                    </router-link>
                                                </slot>
                                            </slot>
                                        </div>
                                    </div>
                                </td>
                            </slot>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr>
                            <td :colspan="Object.keys(columns).length + 2" style="text-align: center;background: #fff">
                                <img :src="$root.baseurl +'/images/nodatafound.png'" style="    height: 20em;
    width: 30em;
    object-fit: contain;" alt="">
                            </td>
                        </tr>
                        </tbody>
                    </slot>
                </table>
                <div
                    v-if="$root.tableSpinner"
                    class="text-center"
                    style="font-size: 17px; color: #adadad"
                >
                    <!-- <span class="processing">loading</span> -->
                    <span class="fa fa-circle-o-notch fa-spin"></span>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "BaseTable",
    data() {
        return {
            order: "desc",
            coloumSort: "",
            sorting_spin: false,
        };
    },
    props: ["data", "columns", "routes"],
    methods: {
        hasValue(item, column) {
            return item[column.toLowerCase()] !== "undefined";
        },
        itemValue(item, column, subcolunn = "") {
            var objcolumn = item[column.toLowerCase()];
            if (objcolumn == null) {
                return objcolumn;
            } else if (typeof objcolumn == "object") {
                return item[column.toLowerCase()][subcolunn.toLowerCase()];
            } else {
                return objcolumn;
            }
        },
        destroy(id) {
            // const sp = this.routes.view.split(".");
            if (confirm("Are you sure want to delete?")) {
                this.$parent.destroy(id);
            }
        },
        tableSorting(number, id, model, auto) {
            $(".change_sorting").removeClass("sorting-success");
            this.sorting_spin = id;
            let data = {number: number, id: id, model: model, auto: auto};
            axios
                .get("table-sorting", {params: data})
                .then((res) => this.$parent.search())
                .catch((error) => console.log(error))
                .then((alw) => {
                    this.sorting_spin = "";
                    $(".change_sorting" + number).addClass("sorting-success");
                });

            setTimeout(
                () => $(".change_sorting").removeClass("sorting-success"),
                5000
            );
        },
        sort(field) {
            this.coloumSort = field;
            this.data.sort(this.sortBy(field));
        },
        sortBy(property) {
            if (this.order === "desc") {
                this.order = "asc";
            } else {
                this.order = "desc";
            }
            const order = this.order;
            return function (a, b) {
                const varA =
                    typeof a[property] === "string"
                        ? a[property].toUpperCase()
                        : a[property];
                const varB =
                    typeof b[property] === "string"
                        ? b[property].toUpperCase()
                        : b[property];

                let comparison = 0;
                if (varA > varB) comparison = 1;
                else if (varA < varB) comparison = -1;
                return order === "desc" ? comparison * -1 : comparison;
            };
        },
        generatePdf() {
            const doc = new jsPDF();
            $(".action").css("display", "none");
            autoTable(doc, {html: "#pdf-table"});
            doc.save(this.$parent.model + ".pdf");
            setTimeout(() => $(".action").show(), 300);
        },
    },
};
</script>
