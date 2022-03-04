<template>
    <div class="ff-workbench" ref="refWorkBench">

        <my-tab ref="refTab"
                :pConfig= this.cfgtime.tabConfig
                @emitClickTab="emitClickTab"
        >
            <template v-slot:tabs>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_NEW.id)">
                    <div class="up-line"></div>
                    <my-incasez :ref="this.cfgtime.REF_FORM_INCASEZ"></my-incasez>
                </div>
                <div class="tab" :id="this.$constTab.getIdTab(this.cfgtime.tabConfig.TAB_LIST.id)">
                    <div class="up-line"></div>
                    <my-lista-incasari :ref = "this.cfgtime.REF_FORM_LISTA_INCASARI"></my-lista-incasari>
                </div>
            </template>
        </my-tab>

    </div>
</template>

<script>

import Tab from "@/components/base/Tab";
import formIncasez from "@/components/app/form/formIncasez";
import formIncasezListaIncasari from "@/components/app/form/formIncasezListaIncasari";

export default {
    components: {
        'my-tab': Tab,
	    'my-incasez': formIncasez,
        'my-lista-incasari': formIncasezListaIncasari
    },
    name: "view-incasari",
    created() {
        this.cfgtime = {
        	REF_FORM_INCASEZ: 'refFormIncasez',
            REF_FORM_LISTA_INCASARI: 'refFormListaIncasari',
            tabConfig: {
                TAB_NEW: {id: '1t'},
                TAB_LIST: {id: '2t'},
                header: [
                    this.$constTab.getHeader('1t', 'Incasez'),
                    this.$constTab.getHeader('2t', 'Lista incasari')
                ],
                defaultTabId: '1t',
                tabsWidth: '1300px'
            }
        }
        this.runtime = {

        }
     },
     mounted(){
         this.$refs.refTab.goToTab(this.cfgtime.tabConfig.defaultTabId);
     },
     methods: {
         emitClickTab: function (idTab) {
             if(idTab == this.cfgtime.tabConfig.TAB_NEW.id) {
                 this.$refs[this.cfgtime.REF_FORM_INCASEZ].refreshListaFacturiNeincasate();

             } else if(idTab == this.cfgtime.tabConfig.TAB_LIST.id) {
                 this.$refs[this.cfgtime.REF_FORM_LISTA_INCASARI].refreshInvoiceList();

             }
         },
     },
     data(){
            return {}
     }
 }

</script>

<style scoped></style>
