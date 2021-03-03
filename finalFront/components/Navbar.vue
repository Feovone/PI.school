<template>
  <b-navbar toggleable="lg" type="dark" variant="dark">
    <b-navbar-brand to="/home" v-if="$auth.user.first_name==null">{{
        $t('nav.hello', {
          firstName: "Anonymous",
          secondName: ""
        })
      }}
    </b-navbar-brand>
    <b-navbar-brand to="/home" v-else> {{
        $t('nav.hello', {
          firstName: $auth.user.first_name,
          secondName: $auth.user.last_name
        })
      }}
    </b-navbar-brand>
    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
    <b-collapse id="nav-collapse" is-nav>

      <!-- Right aligned nav items -->
      <b-navbar-nav class="ml-auto">
        <b-nav-item-dropdown :text="$t('nav.lang')" right>
          <Locale/>
        </b-nav-item-dropdown>

        <b-nav-item-dropdown right>
          <template #button-content>
            <span id="profile-photo-thumb" class="my-auto " right></span>
          </template>

          <b-dropdown-item to="/profile"> {{ $t('nav.profile') }}</b-dropdown-item>
          <b-dropdown-item v-b-modal.modal-report-create> {{ $t('nav.report') }}</b-dropdown-item>
          <b-dropdown-item @click="$auth.logout()">{{ $t('nav.logout') }}</b-dropdown-item>
        </b-nav-item-dropdown>
        <ReportCreate/>
      </b-navbar-nav>
    </b-collapse>
  </b-navbar>
</template>

<script>

import Locale from '../components/Locale.vue'
import ReportCreate from "@/components/modal/ReportCreate";

export default {
  name: "navbar",
  components: {
    Locale
  },
  methods: {
    async image(label) {
      await this.$store.dispatch('user/FETCH', "thumb");
      let src = this.$store.state.user.userPhoto;
      const img = document.createElement('img');
      img.setAttribute('id', "user-photo-thumb");
      img.classList.add('img-fluid');
      img.classList.add('img-circle');
      img.classList.add('rounded-circle');
      img.classList.add('border');
      img.style.maxWidth = "100%";
      img.style.width = "30px";
      img.style.height = "30px";
      img.src = src;
      let el = document.getElementById('user-photo-thumb')
      if (el != null) {
        el.remove();
      }
      let element = document.getElementById(label);
      element.appendChild(img);
    }
  },
  mounted() {
    this.image("profile-photo-thumb");
  }
}
</script>

<style scoped>
.navbar.navbar-dark.bg-dark {
  background-color: #3267AD !important;
}


</style>
