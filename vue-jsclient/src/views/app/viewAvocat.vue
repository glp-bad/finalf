<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab ref="refTab"
            :pConfig=this.gridConfig
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
                        <form-luni></form-luni>
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
            this.gridConfig = {
                header: [
                    this.$constTab.getHeader(1,'Date avocat'),
                    this.$constTab.getHeader(2,'Tab 02'),
                    this.$constTab.getHeader(3,'Tab 03'),
                    this.$constTab.getHeader(4,'Luni in lucru')
                ],
                defaultTabId: 3,
                tabsWidth: '700px'
            }
		},
        mounted () {
		    this.$refs.refTab.goToTab(this.gridConfig.defaultTabId);
        },
		methods: {
		    emitClickTab: function (idTab) {
            }
		},
		data () {
			return {
            }
		}
	}

</script>

<style scoped></style>
