<template>
  <fragment>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <div class="row">
          <div class="col">
            <h6 class="m-0 font-weight-bold text-primary">Expenses</h6>
          </div>
          <div class="col-4"></div>
          <div class="col">
            <b-button v-b-modal.modal-1 variant="primary" class="btn btn-sm">Add Expense</b-button>
            <button class="btn btn-danger btn-sm" @click="generatePdf">
              <i class="fas fa-file-download"></i> &nbsp;PDF
            </button>
            <export-excel :data="expenses" :fields="json_fields" class="btn btn-success btn-sm">
              <i class="fas fa-cloud-download-alt"></i> &nbsp;Excel
            </export-excel>
            <b-form-select
              v-model="selectedMonth"
              :options="options"
              size="sm"
              @change="selectMonth"
              style="max-width:8rem"
            ></b-form-select>
          </div>
        </div>
      </div>
      <div class="card-body">
        <vue-good-table
          v-if="expenses && expenses.length"
          :columns="tableColumns1"
          :rows="expenses"
          :line-numbers="true"
          :search-options="{
    enabled: true,
       placeholder: 'Type to search',
  }"
          :pagination-options="{
        enabled: true,
        mode: 'pages',
        
      }"
        >
          <template slot="table-row" slot-scope="props">
            <span v-if="props.column.field == 'action'">
              <a
                data-toggle="tooltip"
                data-placement="top"
                title="Delete "
                @click="deleteItem(props.row.id)"
              >
                <i class="fas fa-trash text-danger"></i>
              </a>
            </span>

            <span v-else>{{props.formattedRow[props.column.field]}}</span>
          </template>
        </vue-good-table>
      </div>
    </div>

    <!-- add expense -->
    <b-modal id="modal-1" title="Create">
      <b-tabs content-class="mt-3" fill active>
        <b-tab title="Expense" active>
          <AddExpense></AddExpense>
        </b-tab>
        <b-tab title="Expense Category">
          <AddExpenseCategory></AddExpenseCategory>
        </b-tab>
      </b-tabs>
      <template v-slot:modal-footer>
        <div class="w-100">
          <!-- <b-button
            type="submit"
            @click="onSubmit"
            variant="primary"
            size="sm"
            class="float-right"
          >Add</b-button>-->
        </div>
      </template>
    </b-modal>
  </fragment>
</template>

<script>
import jsPDF from "jspdf";
import { mapGetters } from "vuex";
import AddExpense from "./AddExpense";
import AddExpenseCategory from "./AddExpenseCategory";

export default {
  data() {
    return {
      show: false,
      form: new Form({
        category_id: "",
        date: "",
        name: "",
        note: "",
        amount: 0,
      }),
      selectedMonth: "all",
      options: [
        { value: "all", text: "All" },
        { value: "this_month", text: "This month" },
        { value: "last_month", text: "Last month" },
      ],
      json_fields: {
        Name: "name",
        Amount: "amount",
        Note: "note",
        "Category Name": "category_name",
        Date: "date",
      },
      tableColumns1: [
        {
          label: "Name",
          field: "name",
        },
        {
          label: "Amount",
          field: "amount",
        },
        {
          label: "Note",
          field: "note",
        },
        {
          label: "Category Name",
          field: "category_name",
        },
        {
          label: "Date",
          field: "date",
        },

        {
          label: "Action",
          field: "action",
        },
      ],
    };
  },
  components: {
    AddExpense,
    AddExpenseCategory,
  },
  methods: {
    generatePdf() {
      const vm = this;
      const columns = [
        { title: "Name", dataKey: "name" },
        { title: "Amount", dataKey: "amount" },
        { title: "Note", dataKey: "note" },
        { title: "Category name", dataKey: "category_name" },
        { title: "Date", dataKey: "date" },
      ];
      const doc = new jsPDF("p", "pt");

      doc.autoTable(columns, vm.expenses, {
        styles: {
          fontSize: 10,
        },
      });

      doc.save("expense.pdf");
    },
    deleteItem(item_id) {
      axios
        .delete(`/api/expenses/${item_id}`)
        .then((response) => {
          this.$store.dispatch("RETRIEVE_EXPENSES");
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Deleted Successfully",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((error) =>
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Something went wrong!",
          })
        );
    },
    selectMonth() {
      if (this.selectedMonth === "this_month") {
        this.$store.dispatch("RETRIEVE_THIS_MONTH_EXPENSES");
      } else if (this.selectedMonth === "last_month") {
        this.$store.dispatch("RETRIEVE_LAST_MONTH_EXPENSES");
      } else {
        this.$store.dispatch("RETRIEVE_EXPENSES");
      }
    },
  },
  created() {
    this.$store.dispatch("RETRIEVE_EXPENSES");
  },
  computed: {
    ...mapGetters({
      expenses: "getExpenses",
    }),
  },
};
</script>