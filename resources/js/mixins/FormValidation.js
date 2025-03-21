import useVuelidate from '@vuelidate/core';
import { required, minLength, email } from '@vuelidate/validators';

//TC Identity No. checking algorithm for validation
function identityCheck(val) {
  var odd = 0,
    even = 0,
    res = 0,
    total = 0,
    err = [
      11111111110, 22222222220, 33333333330, 44444444440, 55555555550,
      66666666660, 7777777770, 88888888880, 99999999990,
    ];

  if (val.length != 11) return false;
  if (isNaN(val)) return false;
  if (val[0] == 0) return false;

  odd =
    parseInt(val[0]) +
    parseInt(val[2]) +
    parseInt(val[4]) +
    parseInt(val[6]) +
    parseInt(val[8]);
  even =
    parseInt(val[1]) + parseInt(val[3]) + parseInt(val[5]) + parseInt(val[7]);

  odd = odd * 7;
  res = Math.abs(odd - even);
  if (res % 10 != val[9]) return false;

  for (let i = 0; i < 10; i++) {
    total += parseInt(val[i]);
  }

  if (total % 10 != val[10]) return false;

  if (err.toString().indexOf(val) != -1) return false;

  return true;
}


function phoneCheck(val) {
  if (val === "") return true;  // If empty, return true (keep this if needed)
  return /^(018|013|014|015|017|019)\d*$/.test(val);
}

export const FormValidation = {
  validations: {
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
      phoneCheck,
    },
  },
};