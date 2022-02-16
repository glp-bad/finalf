<template>
    <div class="ff-table-list" :ref=REF_TABLE_CONTAINER>
        <div class="tableDiv" :ref=REF_TABLEDIV>
            <table :ref=REF_TABLE>
                <thead :ref=REF_HEAD>
                    <tr v-for="h in pHeader">
                        <th>{{h.caption}}</th>
                    </tr>
                </thead>
                <tbody :ref=REF_BODY>
                    <tr v-for="dt in pData" v-bind:id="dt.id" v-on:keydown.prevent="keyNavigate($event)" v-on:click.prevent="mouseNavigate($event)">
                        <td :tabindex=dt.id>{{dt.caption}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="infoList" :ref=REF_BOTTOM_INFO>
            <div>
                <span>info nr records</span>
            </div>
        </div>
    </div>
</template>

<script>
	export default {
		name: "table-list",
		created() {
            this.REF_TABLE_CONTAINER      = 'tTableRefContainer',
			this.REF_TABLE      = 'tTableRef',
            this.REF_TABLEDIV   = 'tTableDivRef',
			this.REF_HEAD       = 'tHeadRef',
			this.REF_BODY       = 'tBodyRef',
            this.REF_BOTTOM_INFO = 'tBottomInfo',
            this.CLASS_SELECTED = 'selected',
			this.MAX_REZULT_COUNT = 10,           // afisate fara scroll
			this.MAX_REZULT_DIV_HEIGHT = '212px' // in cazul in care se depaseste MAX_REZULT_COUNT
		},
		props: {
		    pHeader: {type: Array, required: false},
			pData: {type: Array, required: true},
            pWidth: {type: Number, required: false}
		},
		mounted() {
		    this.$refs[this.REF_TABLE_CONTAINER].style.width = this.pWidth + 'px';
			this.initTable();

		},
        methods:{
            initTable: function () {
	            // this.engine.maximRows = this.$refs[this.REF_TABLE].rows.length;
                this.engine.maximRows = this.pData.length;
	            if(this.engine.maximRows > 0){
		            this.setTDselected(this.$refs[this.REF_TABLE].rows[0].childNodes[0]);
                }

	            let displayRezumat  = 'none';
                let overflowTable   = null;
                let heightTable     = "100%";

                if(this.engine.maximRows > this.MAX_REZULT_COUNT){
                    overflowTable = 'scroll';
                    displayRezumat = 'block';
                    heightTable = this.MAX_REZULT_DIV_HEIGHT;
                    this.$refs[this.REF_BOTTOM_INFO].childNodes[0].textContent = ' ...found ' + this.engine.maximRows + ' records in the list';
                }


                this.$refs[this.REF_TABLEDIV].style.height = heightTable;
                this.$refs[this.REF_TABLEDIV].style['overflow-y'] = overflowTable;
                this.$refs[this.REF_BOTTOM_INFO].style.display = displayRezumat;

            },

	        mouseNavigate: function (event){
		        this.setTDselected(event.target);
                this.selectData();
                this.$emit(this.engine.emit.selectData);
            },
	        keyNavigate: function (event) {
		        if (event.key == 'ArrowRight') {
			        //this.arrowRight();
		        }else if(event.key == 'ArrowLeft'){
			        //this.arrowLeft();
		        }else if(event.key == 'ArrowDown'){
			        this.arrowDown();
		        }else if(event.key == 'ArrowUp'){
			        this.arrowUp();
		        }else if(event.key == 'Enter'){
                    this.selectData();
                    this.$emit(this.engine.emit.selectData);
		        }else if(event.key == 'Tab'){
                    this.$emit(this.engine.emit.tabKey);
                }
		        // console.log(event.key)
            },

	        arrowRight: function () {},
	        arrowLeft: function () {},
	        arrowUp: function () {
		        if(this.engine.trCurent.sectionRowIndex > 0) {
			        this.setTDselected(this.engine.tdCurent.parentNode.previousSibling.getElementsByTagName('td')[0]);
                    this.selectData();
		        }
	        },
	        arrowDown: function () {
	        	if(this.engine.trCurent.sectionRowIndex < (this.engine.maximRows - 1)) {
			        this.setTDselected(this.engine.tdCurent.parentNode.nextSibling.getElementsByTagName('td')[0]);
                    this.selectData();
		        }
	        },
            setFocus: function (){
                this.engine.tdCurent.focus();
            },
            selectData: function (){
                this.dataSelected.id =  this.engine.trCurent.getAttribute('id') ;
                this.dataSelected.caption = this.engine.tdCurent.innerHTML;
            },
            setTDselected: function (td) {

                if(this.engine.tdCurent != null){
	                this.engine.tdCurent.removeAttribute('class', this.CLASS_SELECTED);
                }

	            this.engine.tdCurent = td;
	            this.engine.trCurent = td.parentNode;
	            this.engine.tdCurent.setAttribute('class', this.CLASS_SELECTED);

	            this.setFocus();
            },
            getDataSelected: function () {
                return this.dataSelected;
            },
            getCountRecords: function () {
                return this.engine.maximRows;
            }

        },
		data () {
			return {
				engine:{
					tdCurent: null,
					trCurent: null,
                    maximRows: 0,
                    emit: {selectData: "selectData", tabKey: "tabKey"}
                },
				dataSelected: {id: 0, caption: null}
            }
		}
	}
</script>

<style scoped>
</style>
