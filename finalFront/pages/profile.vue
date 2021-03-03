<template>
  <div class="container mt-4">
    <div class="row">
      <div class="col-10">
        <h1>{{ $t('profile.profile') }}:</h1>
      </div>
      <div class="col-2 my-auto ">
        <button class="btn btn-primary px-5" v-b-modal.modal-user-edit>{{ $t('profile.editButton') }}</button>
      </div>
      <UserEdit/>
    </div>
    <div class="row mt-5 pt-5">
      <div class="col-6 text-center">
        <label id="profile-label"><input type="file" hidden multiple ref="file" v-on:change="uploadImage()">
        </label>
      </div>
      <div class="col-6">
        <b-table-simple>
          <b-tbody>
            <b-tr>
              <b-td>{{ $t('profile.firstName') }}</b-td>
              <b-td>{{ this.$auth.user.first_name }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>{{ $t('profile.lastName') }}</b-td>
              <b-td>{{ this.$auth.user.last_name }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>{{ $t('profile.taxRate') }}</b-td>
              <b-td>{{ this.$auth.user.tax_rate }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>{{ $t('profile.forceExchange') }}</b-td>
              <b-td>{{ this.$auth.user.force_exchange_flag }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>{{ $t('profile.forceExchangeAmount') }}</b-td>
              <b-td>{{ this.$auth.user.force_exchange_percentage }}</b-td>
            </b-tr>
            <b-tr>
              <b-td>{{ $t('profile.notification') }}</b-td>
              <b-td>{{ this.$auth.user.notification_period }}</b-td>
            </b-tr>
            <b-tr>
            </b-tr>
          </b-tbody>
        </b-table-simple>
      </div>
    </div>
  </div>
</template>

<script>
import UserEdit from "@/components/modal/UserEdit";

export default {
  name: "profile",
  layout: 'navbar',
  middleware: 'authenticated',
  data() {
    return {
      file: '',
    }
  },
  methods: {
    async image(label) {
      await this.$store.dispatch('user/FETCH', "");
      let src = this.$store.state.user.userPhoto;
      const img = document.createElement('img');
      img.setAttribute('id', "user-photo");
      img.classList.add('img-fluid');
      img.classList.add('img-thumbnail');
      img.classList.add('border');
      img.style.maxWidth = "100%";
      img.style.width = "300px";
      img.style.height = "300px";
      img.src = src;
      let el = document.getElementById('user-photo')
      if (el != null) {
        el.remove();
      }
      let element = document.getElementById(label);
      element.appendChild(img);
      this.$forceUpdate();
    },

    async uploadImage() {
      this.file = this.$refs.file.files[0];
      if (this.file.size < 2097152) {
        let picture = new FormData();
        picture.append('file', this.file);
        await this.$axios.post('/api/userPhotoStore', picture)
        await this.image("profile-label");
      } else {
        this.$toast.error('Size more 20 mb')
      }
    },
  },
  mounted() {
    this.image("profile-label");
  }

}
</script>

<style scoped>
label {
  cursor: pointer;
}
</style>
