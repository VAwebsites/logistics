<template>
  <fragment>
    <div class="row mt-3 mb-3 ml-3 d-print-none">
      <div class="col"></div>
      <div class="col"></div>
      <div class="col">
        <a
          class="btn btn-primary text-white"
          onclick="javascript:window.print()"
        >
          <i class="fas fa-print"></i> Print
        </a>

        <button
          href
          class="btn btn-danger ml-2"
          @click.prevent="updateStatus('decline')"
          v-show="!quote.status"
        >
          <i class="fas fa-times"></i> Decline
        </button>
        <button
          class="btn btn-success ml-2"
          @click.prevent="updateStatus('approve')"
          v-show="!quote.status"
        >
          <i class="fas fa-check"></i> Approve
        </button>
        <button @click="$router.go(-1)" class="btn btn-dark ml-2">
          <i class="fas fa-arrow-left"></i> Return
        </button>
      </div>
    </div>
    <div class="card" ref="content">
      <div class="card-body">
        <div class="row mt-2">
          <div class="col">
            <img :src="logo" style="max-width: 8rem" />
          </div>
          <div class="col"></div>
          <div class="col">
            <p>
              GURUKAL LOGISTICS
              <br />Anchepalya, Bangalore - 560073 <br />Mob: +91 9620202001
              <br />E-mail : logistics@gurukal.co.in <br />Website:
              www.gurukal.co.in
              <br />
            </p>
          </div>
        </div>
        <hr />
        <div class="row">
          <div class="col">
            <p>Ref No: {{ quote.quotation_no }}</p>
          </div>
          <div class="col"></div>
          <div class="col">
            Date: {{ moment(quote.created_at).format("DD/MM/YYYY") }}
          </div>
        </div>

        <div class="row mt-2">
          <div class="col text-center">
            <h5>
              <u>For Transit</u>
            </h5>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <p>
              To,
              <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ quote.customer.company_name }}
              <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ quote.customer.address }}
              <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ quote.customer.gst }}
              <br />
            </p>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col text-center">
            <h6>
              Sub: Transit Quote for
              {{
                quote.list[0].to.charAt(0).toUpperCase() +
                quote.list[0].to.slice(1)
              }}
            </h6>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <p>
              Dear Sir,
              <br />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;As
              per our discussion regarding transportation requirement for the
              consignment to
              {{
                quote.list[0].to.charAt(0).toUpperCase() +
                quote.list[0].to.slice(1)
              }}.
            </p>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col text-center">
            <h5>
              <u>Quotation</u>
            </h5>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <table class="table-bordered table">
              <thead>
                <th scope="col">SL</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Description</th>
                <th scope="col">Size(Feet)&#38; Weight</th>
                <th scope="col">ETA</th>
                <th scope="col">Rate</th>
                <th scope="col">Advance</th>
              </thead>
              <tr v-if="quote.list" v-for="(item, index) in quote.list">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ item.from }}</td>
                <td>{{ item.to }}</td>
                <td>{{ item.description }}</td>
                <td>{{ item.size }} & {{ item.weight }}</td>
                <td>{{ item.eta }} days</td>
                <td>{{ item.rate }}</td>
                <td>{{ item.advance }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <h6>Terms & Conditions</h6>
            <ol>
              <li>Rates quoted above are valid for 48Hrs only.</li>
              <li>
                Extra charges will be implied If the consignment exceeds the
                limit of fleet dimension/ RTO Regulations.
              </li>
              <li>
                Advance payment is to be made (unless stated above, in which
                case you shall pay the quoted price).
              </li>
              <li>
                If the unloading time exceeds 4hrs halting will be charged as
                per actuals
              </li>
              <li>
                Payments are to be made within 7 days from the date of invoice.
              </li>
              <li>
                If Vehicle Is Cancelled Prior To 60min/On Arrival Charges Are
                Applicable.
              </li>
            </ol>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col">
            <p>
              Bank Details
              <br />Name : Axis Bank <br />8th Mile Branch <br />A/c No.:
              918020030455515 <br />IFSC: UTIB0002926
              <br />
            </p>
          </div>
        </div>

        <div class="row mt-2">
          <div class="col-10"></div>
          <div class="col">
            <p>For and behalf of</p>
            <img
              :src="sign"
              alt="Rohith"
              class="img-fluid ml-3"
              style="width: 6rem"
            />
            <br />
            <br />

            <u>Gurukal Logistics</u>
          </div>
        </div>
      </div>
    </div>
  </fragment>
</template>

<script>
export default {
  data() {
    return {
      showUpdation: true,
      logo: "https://i.ibb.co/WFdrW4M/Logo-Color-Text-Below.jpg",
      sign: "https://i.ibb.co/W6vkYqs/seal.png",
    };
  },
  methods: {
    updateStatus(status) {
      if (status == "approve") {
        axios
          .post(`/api/quotations/${this.quote.id}/status/approve`)
          .then((response) => {
            this.$store.dispatch(
              "retrieveSingleQuote",
              this.$route.params.quote_id
            );
            this.showUpdation = false;
          })
          .catch(function (error) {
            console.log("Something went wrong");
          });
      } else if (status == "decline") {
        axios
          .post(`/api/quotations/${this.quote.id}/status/decline`)
          .then((response) => {
            this.$store.dispatch(
              "retrieveSingleQuote",
              this.$route.params.quote_id
            );
            this.showUpdation = false;
          })
          .catch(function (error) {
            console.log("Something went wrong");
          });
      }
    },
  },
  computed: {
    quote() {
      return new Form(this.$store.getters.getSingleQuote);
    },
  },
  created() {
    this.$store.dispatch("retrieveSingleQuote", this.$route.params.quote_id);
  },
};
</script>