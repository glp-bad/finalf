<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab ref="refTab"
            :pConfig=this.cfgtime.gridConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                    <div class="tab" :id="this.$constTab.getIdTab('1')">
                        <div class="up-line"></div>
                        <form-avocat ref="refFormAvocat"></form-avocat>
                    </div>
                    <div class="tab" :id="this.$constTab.getIdTab('2')">
                        <div class="up-line"></div>
                        sunt in tab 2</div>
                    <div class="tab" :id="this.$constTab.getIdTab('3')">
                        <div class="up-line"></div>
                        sunt in tab 3</div>
                    <div class="tab" :id="this.$constTab.getIdTab('4')">
                        <div class="up-line"></div>
                        <form-luni :ref="this.cfgtime.REF_FORM_LUNI_INCHISE"></form-luni>
                    </div>
            </template>
        </my-tab>

    </div>
</template>

<script>
    import formAvocat from "@/components/app/formAvocat";
    import Tab from "@/components/base/Tab";
    import formAvocatLuni from "@/components/app/form/formAvocatLuni.vue";



    export default {
		components: {
            'form-avocat': formAvocat,
            'my-tab': Tab,
            'form-luni': formAvocatLuni
        },
		name: "view-avocat",
		created() {
			this.cfgtime = {
				REF_FORM_LUNI_INCHISE: 'refFormLuniInchise',
				gridConfig : {
					header: [
						this.$constTab.getHeader(1,'Date avocat'),
						this.$constTab.getHeader(2,'Tab 02'),
						this.$constTab.getHeader(3,'Tab 03'),
						this.$constTab.getHeader(4,'Luni in lucru')
					],
					defaultTabId: 1,
					tabsWidth: '700px'
				}
            },
            this.runtime = {
            }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.cfgtime.gridConfig.defaultTabId);
        },
		methods: {
		    emitClickTab: function (idTab) {
		    	if(idTab == 4){
                    this.$refs[this.cfgtime.REF_FORM_LUNI_INCHISE].refreshListLuniInchise();
                }
            }
		},
		data () {
			return {
            }
		}
	}

</script>

<style scoped></style>
