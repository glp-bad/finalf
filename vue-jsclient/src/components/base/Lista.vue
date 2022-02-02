<template>
    <div class="ff-lista">
        <div class="container">

            <table class="tableClass">

              <thead class="theadClass">
                <tr>
                    <template v-for="ph in pConfig.header">
                        <th class="thClass">{{ph.caption}}</th>
                    </template>
                </tr>
              </thead>
              <tbody class="tbodyClass">
                  <template v-for="(tr, index) in this.dataList">
                        <tr>
                            <template v-for="(td, index) in tr" v-bind:key="index">
                                <td>{{td}}</td>
                            </template>
                        </tr>
                  </template>
              </tbody>

            </table>

        </div>
    </div>
</template>
<script>
	export default {
		name: "my-lista",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
        created() {
        },
        mounted() {
		    if(this.pConfig.cfg.loadOnCreate) {
                this.showList();
            }
        },
        methods: {
		    showList: function (){
                this.getDataFromServer();
            },
            getDataFromServer: function () {
                this.showModalLoadingDiv = true;

                let uri = this.$url.getUrl(this.pConfig.cfg.urlData);
                this.axios
                    .post(uri, this.post)
                    .then(response => {
                        this.showModalLoadingDiv = true;
                        this.dataList = response.data;
                    })
                    .catch(error => console.log(error))
                    .finally(() => {
                        this.showModalLoadingDiv = false;
                    });

            }
        },
		data () {
			return {
                showModalLoadingDiv: false,
                dataList: null
            }
		}
	}

</script>

<style scoped>
</style>
