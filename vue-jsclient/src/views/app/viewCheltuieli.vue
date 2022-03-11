<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab ref="refTab"
                :pConfig= this.cfgtime.tabConfig
                @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_NEW.id)">
                    <div class="up-line"></div>
                    <my-cheltuiala_new :ref=this.cfgtime.REF_CHELTUIALA_NEW></my-cheltuiala_new>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_LIST.id)">
                    <div class="up-line"></div>
                </div>
            </template>
        </my-tab>

    </div>
</template>

<script>

import Tab from "@/components/base/Tab";
//import formInvoiceMake from "@/components/app/form/formInvoiceMake";
import formCheltuieliNew from "@/components/app/form/cheltuieli/formCheltuieliNew";


export default {
    components: {
        'my-tab': Tab,
	    'my-cheltuiala_new': formCheltuieliNew
        //'invoice-make': formInvoiceMake,
        //'invoice-list': formInvoiceList
    },
    name: "view-invoices",
    created() {
        this.cfgtime = {
	        REF_CHELTUIALA_NEW: 'refCheltuialaNew',
            tabConfig: {
                TAB_NEW: {id: '1t'},
                TAB_LIST: {id: '2t'},
                header: [
                    this.$constTab.getHeader('1t', 'Cheltuiala noua'),
                    this.$constTab.getHeader('2t', 'Lista cheltuieli')
                ],
                defaultTabId: '1t',
                tabsWidth: '1400px'
            }
        }
     },
     mounted(){
         this.$refs.refTab.goToTab(this.cfgtime.tabConfig.defaultTabId);
     },
     methods: {
         emitClickTab: function (idTab) {
             if(idTab == this.cfgtime.tabConfig.TAB_NEW.id) {
	             this.$refs[this.cfgtime.REF_CHELTUIALA_NEW].serverCheckWorkingExpense();

             } else if(idTab == this.cfgtime.tabConfig.TAB_LIST.id) {
                 //this.$refs[this.cfgtime.REF_INVOICE_LIST].refreshInvoiceList();
             }
         },
     },
     data(){
            return {}
     }
 }

</script>

<style scoped></style>
