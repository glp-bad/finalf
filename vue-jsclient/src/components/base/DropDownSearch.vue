<template>
    <div class="ff-dropdown-search" :ref=REF_DIV_CONTAINER>

        <div class = "loading-modal" v-if="this.showModalLoadingDiv">
            <div>
                <font-awesome-icon :icon=this.$constComponent.ICON_SPINNER size="1x" spin/>
            </div>
        </div>

        <input :ref=REF_SEARCH type="text" v-on:keyup="keySearch" :placeholder=this.pConfig.placeHolder v-bind:class="{'disable-background': this.readOnly }"/>
        <!-- <div class="icon" :ref=REF_ICON @click="iconClick"><i class="fas fa-search"></i></div> -->
        <div class="icon" :ref=REF_ICON @click="iconClick">
            <font-awesome-icon :icon="['fas', 'search']" size="1x"/>
        </div>


        <div class="rezult" :ref=REF_REZULT>

            <list-rezult
                ref= 'selectDataFromListRef'
                :pData=this.rezultData
                @selectData = "emitSelectData"
                @tabKey = "emitPressTabKey"
                :key=this.engine.keyRender
                :pWidth = this.pConfig.sizeField

            ></list-rezult>

        </div>
    </div>
</template>

<script>

    import TableList from "./TableList";

	export default {
		name: "drop-down-search",
		created() {
		    this.REF_DIV_CONTAINER = 'divContainer',
			this.REF_SEARCH = 'searchRef',
			this.REF_ICON = 'iconRef',
            this.REF_REZULT = 'rezultRef',
			this.REF_TABLE_REZULT = 'tableRef',
            this.DATA_METHOD_LOCAL = 'local',
			this.DATA_METHOD_SERVER = 'server',
            this.LAST_LETTERS_NUMBER_FOR_SEARCH = 3,
			this.DELAY_FOR_SEARCCING = 600,
			this.MAX_REZULT_COUNT = 10,           // afisate fara scroll
			this.MAX_REZULT_DIV_HEIGHT = '300px', // in cazul in care se depaseste MAX_REZULT_COUNT
            this.KEY_PRESS_CONTROL_BROWSER = ['Tab', 'Escape']
		},
		props: {
			pConfig: {type: Object, required: true}

		},
        components: {
            'list-rezult': TableList
        },
		mounted() {
			if(this.pConfig.dataMethod == this.DATA_METHOD_LOCAL){
                this.getDataFromServer();
            }

			this.$refs[this.REF_DIV_CONTAINER].style.width = this.pConfig.sizeField + 'px';

		},
        methods:{
		    emitSelectData: function (){
                this.setDataSelected(this.$refs.selectDataFromListRef.getDataSelected());
                this.hideOption();

            },
            emitPressTabKey: function (){
		        this.$refs[this.REF_SEARCH].focus();
            },
            setReadOnly: function (readOnly) {
                if(readOnly) {
                    this.$refs[this.REF_SEARCH].setAttribute('readonly', readOnly);
                }else{
                    this.$refs[this.REF_SEARCH].removeAttribute('readonly');
                }

                this.readOnly = readOnly;
            },
            setDataSelected(data){
	            this.dataSelected = data;
	            this.$refs[this.REF_SEARCH].value = this.dataSelected.caption;
            },
            getValue: function (){
		        return this.dataSelected;
            },
	        resetDataSelected(){
                this.dataSelected = null;
	        },
            clearWordSearch(){
                this.$refs[this.REF_SEARCH].value = '';
            },
			iconClick: function () {
                this.$refs[this.REF_SEARCH].focus();
			},
	        keySearch: function (event) {

		        if(!this.readOnly) {
                    if (this.KEY_PRESS_CONTROL_BROWSER.includes(event.key)) {
                        // do nothing
                    } else {
                        this.post.wordSearch = this.$refs[this.REF_SEARCH].value;
                        this.resetDataSelected();
                        this.delaySearchCancel();

                        if (this.post.wordSearch.length >= this.LAST_LETTERS_NUMBER_FOR_SEARCH) {
                            this.delaySearch();
                        } else {
                            this.hideOption();
                        }
                    }
                }
	        },
            hideOption: function (){
                this.resetRezultData();
                this.showOptionList();
            },
            resetRezultData: function (){
                this.rezultData = new Array();
            },
            showOptionList: function (){
                ++this.engine.keyRender;       // force render list (change key)
                let display = 'none';
                if(this.rezultData.length > 0){
                    display = 'block';
                }
                this.$refs[this.REF_REZULT].style.display = display;
            },
            search: function () {
	            if(this.pConfig.dataMethod == this.DATA_METHOD_LOCAL){
		            // console.log('search: ', this.localData);
		            this.rezultData = this.localData.filter(dataText => dataText.caption.toLowerCase().indexOf(this.post.wordSearch.toLowerCase()) !== -1);
                    this.showOptionList();
                }

	            if(this.pConfig.dataMethod == this.DATA_METHOD_SERVER){
                    this.getDataFromServer();
	            }
            },
            delaySearch: function(){
	            this.timeOut = setTimeout( () => this.search(), this.DELAY_FOR_SEARCCING);
            },
	        delaySearchCancel: function(){
				if(this.timeOut != null){
					clearTimeout(this.timeOut);
                }
	        },
            getDataFromServer: function () {
	            this.showModalLoadingDiv = true;
	            this.$vanilla.inputReadOnly(this.$refs[this.REF_SEARCH], true);

	            this.axios
		            .post(this.pConfig.url, this.post)
		            .then(response => {
                            if(this.pConfig.dataMethod == this.DATA_METHOD_LOCAL) {
                                this.localData = response.data;
                            }

                            if(this.pConfig.dataMethod == this.DATA_METHOD_SERVER) {
                                this.rezultData = response.data.records;
                                this.showOptionList();
                            }
			            }
		            )
		            .catch(error => console.log(error))
		            .finally(() => {
			            this.$vanilla.inputReadOnly(this.$refs[this.REF_SEARCH], false);
			            this.showModalLoadingDiv = false;
		            });

            }
        },
		data () {
			return {
				showModalLoadingDiv: false,
			    engine: {keyRender: 1},
                localData: null,
				rezultData: new Array(),
                countRezultData: 0,
                timeOut: null,
				post:  {wordSearch: null},
				dataSelected: null,
                readOnly: false
            }
		}
	}
</script>

<style scoped>
</style>
