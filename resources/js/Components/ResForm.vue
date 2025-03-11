<template>
    <div class="testbox d-flex flex-column">
      <form>
        <fieldset>
          <div class="columns">
            <!-- Name input area and validations -->
            <div class="item">
              
              <label class="form__label" for="fname"
                >First Name<span>*</span></label
              >
              <input
                class="form__input"
                v-model.trim="$v.fname.$model"
                id="fname"
                type="text"
                name="fname"
                placeholder="Fatih"
                ref="input"
              />
              <div class="error" v-if="!$v.fname.required && $v.fname.$dirty">
                Name is required
              </div>
              <div class="error" v-if="!$v.fname.minLength">
                Name must have at least
                {{ $v.fname.$params.minLength.min }} letters.
              </div>
            </div>
            <!-- Last name input area and validations -->
            <div class="item">
              
              <label class="form__label" for="lname">
                Last Name<span>*</span></label
              >
              <input
                class="form__input"
                v-model.trim="$v.lname.$model"
                id="lname"
                type="text"
                name="lname"
                placeholder="Ozoglu"
              />
              <div class="error" v-if="!$v.lname.required && $v.lname.$dirty">
                Last name is required
              </div>
              <div class="error" v-if="!$v.lname.minLength">
                Name must have at least
                {{ $v.lname.$params.minLength.min }} letters.
              </div>
            </div>
            
            <!-- Sex input area and validations -->
            <div class="item">
              
              <label class="d-block mb-1" for="sex">Sex<span>*</span></label>
              <select v-model.trim="$v.sex.$model" name="sex" id="sex">
                <option value="" disabled selected>Select Your Sex</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
  
              <div class="error" v-if="!$v.sex.required && $v.sex.$dirty">
                Please enter your sex
              </div>
            </div>
            <!-- T.C. Identity No. input area and validations -->
            <div class="item">
              
              <label for="tc">Identity No.<span>*</span></label>
              <input
                v-model.trim="$v.tc.$model"
                id="tc"
                type="text"
                name="tc"
                placeholder="Identity No."
              />
  
              <div class="error" v-if="!$v.tc.required && $v.tc.$dirty">
                Please enter your identity number
              </div>
              <div
                class="error"
                v-if="$v.tc.$model !== '' && $v.tc.$dirty"
              >
                Please enter a valid identity number
              </div>
            </div>
          
            <!-- E-mail input area and validations -->
            <div class="item">
              
              <label class="form__label" for="email"
                >Email Address<span>*</span></label
              >
              <input
                class="form__input"
                v-model.trim="$v.email.$model"
                id="email"
                type="email"
                name="email"
                placeholder="fatihozoglu@yahoo.com"
              />
              <div class="error" v-if="!$v.email.required && $v.email.$dirty">
                Email is required
              </div>
              <div class="error" v-if="!$v.email.email">
                Please enter a valid e-mail adress
              </div>
            </div>
            <!-- Phone input area and validations -->
            <div class="item">
              
              <label for="phone">Phone<span>*</span></label>
              <input
                v-model.trim="$v.phone.$model"
                id="phone"
                type="tel"
                name="phone"
                placeholder="5395845151"
              />
              <div class="error" v-if="!$v.phone.required && $v.phone.$dirty">
                Phone number is required
              </div>
              <div class="error" v-if="!$v.phone.phoneCheck && $v.phone.$dirty">
                Please enter a valid phone number
              </div>
            </div>
          </div>
        </fieldset>
        <br />
        
        <!-- Showing "Go to Payment" button for the last form item to route to /payment Payment view component -->
        <button  @click.prevent="goPayment">Go to Payment</button>
      </form>
    </div>
</template>
  
<script>
  import useVuelidate from "@vuelidate/core";
  import { required, minLength, email } from "@vuelidate/validators";
  import { FormValidation } from "@/mixins/FormValidation";

  export default {
    name: "ResForm",
    mixins: [FormValidation],
    data() {
      return {
        fname: "",
        lname: "",
        email: "",
        sex: "",
        tc: "",
        phone: "",
      };
    },
    props: {
      allGuestInfo: Array,
      selectedHotel: Object,
    },
    validations() {
      return {
        fname: {
          required,
          minLength: minLength(3),
        },
        lname: {
          required,
          minLength: minLength(3),
        },
        email: {
          required,
          email,
        },
        sex: {
          required,
        },
        tc: {
          required,
        },
        phone: {
          required,
          phoneCheck: this.phoneCheck
        },
      };
    },

    created() {
      this.$v = useVuelidate();  // Initialize Vuelidate
    },
    methods: {
      phoneCheck(val) {
        if (val === "") return true;  // Allow empty values if needed
        return /^(018|013|014|015|017|019)\d*$/.test(val);
      },
      focus() {
        this.$refs.input.focus();
      },
      checkCompletion() {
        this.$v.$touch();
        if (!this.$v.$invalid) {
          this.$emit("formCompleted", {
            fname: this.fname,
            lname: this.lname,
            email: this.email,
            sex: this.sex,
            tc: this.tc,
            phone: this.phone,
          });
        }
      },
      goPayment() {
        this.checkCompletion();
        if (this.allGuestInfo) {
          this.$emit("goPayment");
          this.$router.push({
            name: "Payment",
            params: { selectedHotel: this.selectedHotel },
          });
        }
      },
    },
  };
</script>

  
<style scoped>
  div,
  form,
  input,
  select,
  textarea,
  label {
    padding: 0;
    margin: 0;
    outline: none;
    font-family: Roboto, Arial, sans-serif;
    font-size: 14px;
    color: #666;
    line-height: 22px;
  }
  h1 {
    position: absolute;
    margin: 0;
    font-size: 50px;
    color: #fff;
    z-index: 2;
    line-height: 83px;
  }
  legend {
    padding: 10px;
    font-family: Roboto, Arial, sans-serif;
    font-size: 18px;
    color: #fff;
    background-color: #1a4a8d;
  }
  textarea {
    width: calc(100% - 12px);
    padding: 5px;
  }
  .testbox {
    display: flex;
    justify-content: center;
    align-items: center;
    height: inherit;
    padding: 20px;
  }
  form {
    width: 100%;
    padding: 20px;
    border-radius: 6px;
    background: #fff;
    box-shadow: 0 0 8px #1a4a8d;
  }
  input,
  select,
  textarea {
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }
  input {
    width: calc(100% - 10px);
    padding: 5px;
  }
  input[type="date"] {
    padding: 4px 5px;
  }
  textarea {
    width: calc(100% - 12px);
    padding: 5px;
  }
  select {
    height: 30px;
  }
  .item:hover p,
  .item:hover i,
  .item input:hover,
  .item select:hover,
  .item textarea:hover {
    border: 1px solid transparent;
    box-shadow: 0 0 3px 0 #1a4a8d;
    color: #1a4a8d;
  }
  .item {
    position: relative;
    margin: 10px 0;
  }
  .item span {
    color: red;
  }
  .item i {
    right: 1%;
    top: 30px;
    z-index: 1;
  }
  .columns {
    display: flex;
    justify-content: space-between;
    flex-direction: row;
    flex-wrap: wrap;
  }
  .columns div {
    width: 48%;
  }
  .btn-block {
    margin-top: 10px;
    text-align: center;
  }
  button {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background: #1a4a8d;
    font-size: 16px;
    color: #fff;
    cursor: pointer;
  }
  button:hover {
    background: #14396d;
  }
  .error {
    color: red;
  }
  @media (min-width: 568px) {
    .name-item,
    .city-item {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
    }
    .name-item input,
    .name-item div {
      width: calc(50% - 20px);
    }
    .name-item div input {
      width: 97%;
    }
    .name-item div label {
      display: block;
      padding-bottom: 5px;
    }
  }
</style>