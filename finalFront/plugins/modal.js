export default ({ app }, inject) => {
  const generatorProperties = function (fields,allFields) {
    let form = {};
    for (let k in allFields) {
      for (let i in fields) {
        if (k === fields[i]) {
          form[k] = allFields[k]
        }
      }
    }
    return {form};
  }
  const validateState = function (name) {
    if (typeof (this.$v.form[name]) != "undefined") {
      const {$dirty, $error} = this.$v.form[name];
      return $dirty ? !$error : null;
    }
  }
  const clearFields=function () {
    let obj = {}
    Object.keys(this.form).forEach(function (key) {
      obj[key] = null;
    }, this.form)
    return obj;
  }

 inject('clearFields', clearFields)
  inject('generatorProperties', generatorProperties)
  inject('validateState', validateState)
}
