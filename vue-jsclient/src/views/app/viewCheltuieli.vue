<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab ref="refTab"
                :pConfig= this.cfgtime.tabConfig
                @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_NEW.id)">
                    <div class="up-line"></div>
                    <my-cheltuiala-new :ref=this.cfgtime.REF_CHELTUIALA_NEW></my-cheltuiala-new>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_LIST.id)">
                    <div class="up-line"></div>
                    <my-cheltuiala-list :ref=this.cfgtime.REF_CHELTUIALA_LIST></my-cheltuiala-list>
                </div>
            </template>
        </my-tab>

    </div>
</template>

<script>

import Tab from "@/components/base/Tab";
import formCheltuieliNew from "@/components/app/form/cheltuieli/formCheltuieliNew";
import formCheltuieliList from "@/components/app/form/cheltuieli/formCheltuieliList";


export default {
    components: {
        'my-tab': Tab,
	    'my-cheltuiala-new': formCheltuieliNew,
        'my-cheltuiala-list':formCheltuieliList

    },
    name: "view-invoices",
    created() {
        this.cfgtime = {
	        REF_CHELTUIALA_NEW: 'refCheltuialaNew',
            REF_CHELTUIALA_LIST: 'refCheltuialaList',
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
                 this.$refs[this.cfgtime.REF_CHELTUIALA_LIST].refreshExpenseList();
             }
         },
     },
     data(){
            return {}
     }
 }

</script>

<style scoped></style>
