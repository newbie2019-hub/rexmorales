export default {
  data() {
    return {

    }
  },
  methods: {
    async callApi(method, url, data) {
      try {
        return await axios({
          method: method,
          url: url,
          data: data
        });
      } catch (e) {
        return e.response
      }
    },
    info(desc) {
      this.$toast.info(desc, {
        position: "top-right",
        timeout: 2500,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },
    notif(desc) {
      this.$toast(desc, {
        position: "top-right",
        timeout: 3000,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },
    success(desc) {
      this.$toast.success(desc, {
        position: "top-right",
        timeout: 2500,
        closeOnClick: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },
    warning(desc) {
      this.$toast.warning(desc, {
        position: "top-right",
        timeout: 2500,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },
    error(desc) {
      this.$toast.error(desc, {
        position: "top-right",
        timeout: 2500,
        closeOnClick: true,
        pauseOnHover: true,
        draggable: true,
        draggablePercent: 0.6,
        showCloseButtonOnHover: false,
        hideProgressBar: true,
        closeButton: "button",
        icon: true,
        rtl: false
      });
    },
  }
}