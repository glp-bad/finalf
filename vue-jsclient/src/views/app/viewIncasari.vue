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
                    sunt in tab 2
                </div>
            </template>
        </my-tab>

    </div>
</template>

<script>

import Tab from "@/components/base/Tab";
import formIncasez from "@/components/app/form/formIncasez";

export default {
    components: {
        'my-tab': Tab,
	    'my-incasez': formIncasez
    },
    name: "view-incasari",
    created() {
        this.cfgtime = {
        	REF_FORM_INCASEZ: 'refFormIncasez',
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
	             console.log('click 1 tab');
             } else if(idTab == this.cfgtime.tabConfig.TAB_LIST.id) {
                 console.log('click 2 tab');
             }
         },
     },
     data(){
            return {}
     }
 }

</script>

<style scoped></style>
