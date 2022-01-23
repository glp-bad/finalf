<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab
            :pConfig=this.gridConfig
            @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tabs" ref="refTabs">
                    <div class="tab" :id="this.$constTab.getIdTab('1')"> <form-avocat ref="refFormAvocat"></form-avocat> </div>
                    <div class="tab" :id="this.$constTab.getIdTab('2')"> sunt in tab 2</div>
                    <div class="tab" :id="this.$constTab.getIdTab('3')"> sunt in tab 3</div>
                    <div class="tab" :id="this.$constTab.getIdTab('4')"> sunt in tab 4</div>
                </div>
            </template>
        </my-tab>

    </div>
</template>

<script>
    import formAvocat from "@/components/app/formAvocat";
    import Tab from "@/components/base/Tab";

    export default {
		components: {
            'form-avocat': formAvocat,
            'my-tab': Tab
        },
		name: "view-avocat",
		created() {
            this.gridConfig = {
                header: [
                    this.$constTab.getHeader(1,'Avocat ramificat 001'),
                    this.$constTab.getHeader(2,'Tab 002'),
                    this.$constTab.getHeader(3,'Si inca un Tab 003'),
                    this.$constTab.getHeader(4,'Si numarul 4')
                ],
                headerIdDefault: 1
            }
		},
        mounted () {

        },
		methods: {
		    emitClickTab: function (idTab) {
                this.$constTab.showTab(this.$constTab.getIdTab(idTab),this.$refs.refTabs);

                // this.$refs.refFormAvocat.showForm(this.$refs.refWorkBench);
            }
		},
		data () {
			return {
            }
		}
	}

</script>

<style scoped></style>
