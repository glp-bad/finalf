<template>
    <div class="ff-tab">
        <div class="headers">
            <ul>
                <template v-for="ph in pConfig.header">
                    <li class='header-li' :ref=this.REF_HEADER_LI>
                        <div class="header-div" :idTab = ph.id>
                            <a :idTab=ph.id @click="this.headerClick($event)" href="javascript:void(null);">{{ph.caption}}</a>
                        </div>
                    </li>
                </template>
            </ul>
        </div>
        <div class="tabs" :ref=this.REF_TABS>
            <slot name="tabs" ></slot>
        </div>
    </div>
</template>
<script>
	export default {
		name: "my-tab",
        props: {
            pConfig: {type: Object, required: true}
        },
		directives: {},
        created() {
            this.REF_HEADER_LI = 'refHeaderLi',
            this.REF_TABS = 'refTabs',
            this.tabEngine = null;
        },
        mounted() {
            this.tabEngine = this.pConfig.header;
        },
        methods: {
            headerClick: function (event) {
                let id = event.target.getAttribute('idTab');
                this.goToTab(id);
            },
            tabOnOff: function (id, onoff){
                let element = this.getTabDiv(id);
                if(onoff == 'on'){
                    this.$constTab.enabledTab(element);
                }else{
                    this.$constTab.disableTab(element);
                }

            },
            goToTab: function (id){
                this.selectdTabId = id;
                this.emitTabAction(id);
                this.headerMarkSelected(id)
            },
            emitTabAction:function(idTab) {
                this.$emit(this.$constTab.EMIT_TAB_ACTION, idTab);
            },
            getTabDiv: function (id){
                let headers = this.$refs[this.REF_HEADER_LI];
                let header = null;
                for(let i=0;i < headers.length;i++) {
                    if (headers[i].firstChild.getAttribute('idTab') == id) {
                        header = headers[i];
                        break;
                    }
                }

                return header;
            },
            headerMarkSelected: function (id) {
                let headers = this.$refs[this.REF_HEADER_LI];
                let tabs = this.$refs[this.REF_TABS].children;

                if(headers.length != tabs.length){
                    console.error('TAB.vue: headers and tabs must be the same value');
                }

                let tabId = this.$constTab.getIdTab(id);
                for(let i=0;i < headers.length;i++){
                    if(headers[i].firstChild.getAttribute('idTab') == id){
                        headers[i].style.backgroundColor = 'black';
                    }else{
                        headers[i].style.backgroundColor = null;
                    }

                    // show tabs
                    if(tabs[i].style.width.length == 0){
                        tabs[i].style.width = this.pConfig.tabsWidth;
                    }

                    if(tabs[i].id == tabId){
                        tabs[i].style.display='block';
                    }else{
                        tabs[i].style.display='none';
                    }

                }
            }
        },
		data () {
			return {
			    selectdTabId: null
            }
		}
	}

</script>

<style scoped>
</style>
