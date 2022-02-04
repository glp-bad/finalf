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
                        <tr class="trClass" :idPk="tr.id">
                            <template v-for="(td, index) in tr" v-bind:key="index">
                                <td class="tdClass" v-if="privateCfgFieldShow(index)">
                                        <div class="tdDiv"> {{td}} </div>
                                </td>
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
			this.runtime = {
				fieldArray: []
            },
			this.privateSetRuntimeData()
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

            },
            privateCfgFieldShow(fieldName){
	            return this.runtime.fieldArray.includes(fieldName);

            },
	        privateSetRuntimeData() {
	            this.pConfig.header.forEach(h => {
		            this.runtime.fieldArray.push(h.fieldName);
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
