<template>
    <div class="ff-dropdown-search">
        <input :ref=REF_SEARCH type="text" v-on:keyup="keySearch" :placeholder=this.pConfig.placeHolder />
        <!-- <div class="icon" :ref=REF_ICON @click="iconClick"><i class="fas fa-search"></i></div> -->
        <div class="icon" :ref=REF_ICON @click="iconClick">
            <font-awesome-icon :icon="['fas', 'search']" size="2x"/>
        </div>


        <div class="rezult" :ref=REF_REZULT>

            <list-rezult
                ref= 'selectDataFromListRef'
                :pData=this.rezultData
                @selectData = "emitSelectData"
                @tabKey = "emitPressTabKey"
                :key=this.engine.keyRender

            ></list-rezult>

        </div>
    </div>
</template>

<script>

    import TableList from "./TableList";

	export default {
		name: "drop-down-search",
		created() {
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

		},
        methods:{
		    emitSelectData: function (){
                this.setDataSelected(this.$refs.selectDataFromListRef.getDataSelected());
                this.hideOption();

            },
            emitPressTabKey: function (){
		        this.$refs[this.REF_SEARCH].focus();
            },
            setDataSelected(data){
	            this.dataSelected = data;
	            this.$refs[this.REF_SEARCH].value = this.dataSelected.caption;
            },
	        resetDataSelected(){
                this.dataSelected = null;
	        },
			iconClick: function () {
                this.$refs[this.REF_SEARCH].focus();
			},
	        keySearch: function (event) {

                if(this.KEY_PRESS_CONTROL_BROWSER.includes(event.key)){
                    // do nothing
                }else{
                    this.post.wordSearch = this.$refs[this.REF_SEARCH].value;
                    this.resetDataSelected();
                    this.delaySearchCancel();

                    if(this.post.wordSearch.length >= this.LAST_LETTERS_NUMBER_FOR_SEARCH){
                        this.delaySearch();
                    }else{
                        this.hideOption();
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
	            this.axios
		            .post(this.pConfig.url, this.post)
		            .then(response => {
                            if(this.pConfig.dataMethod == this.DATA_METHOD_LOCAL) {
                                this.localData = response.data;
                            }

                            if(this.pConfig.dataMethod == this.DATA_METHOD_SERVER) {
                                this.rezultData = response.data;
                                this.showOptionList();
                            }
			            }
		            )
		            .catch(error => console.log(error));

            }
        },
		data () {
			return {
			    engine: {keyRender: 1},
                localData: null,
				rezultData: new Array(),
                countRezultData: 0,
                timeOut: null,
				post:  {wordSearch: null},
				dataSelected: null
            }
		}
	}
</script>

<style scoped>
</style>
