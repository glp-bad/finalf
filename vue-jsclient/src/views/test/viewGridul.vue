<template>

    <div class="ff-grid-all" ref="refGridPrint">
        <my-grid ref="gridPrint"
                 :pConfig=this.gridConfig
                 @invoicePrint="invoicePrint"
                 @editCeva="editCeva"
                 @deleteCevaToolbar="deleteCevaToolbar"
                 @editCevaToolbar = "editCevaToolbar"
        ></my-grid>

        <my-grid-edit ref="refGridEdit"
                      @emitUpdateGrid = "emitUpdateGrid"
        ></my-grid-edit>

    </div>

</template>

<script>
    import Gridul from '@/components/base/Gridul';
    import Button from '@/components/base/Button.vue';
    import editGrid from '@/components/app/test/FormGridEditTest.vue';

    export default {
        name: "view-gridul",
        components: {
            'my-grid': Gridul,
            'my-button': Button,
            'my-grid-edit': editGrid
        },
        props: {},
        created() {
            this.gridConfig = {
                header: [
	                this.$constGrid.HEADER.getHeader(1,'idFiled',30,'id', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, false, false, false),
	                this.$constGrid.HEADER.getHeader(2,'Nume',120,'name', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, true, true),
                    this.$constGrid.HEADER.getHeader(3,'Descriere',400,'description', this.$constGrid.HEADER.CAPTION_TYPE_FIELD, true, false, true),
                    //this.$constGrid.HEADER.getHeader(4,'Rezultat mai bun',120,'rez', this.$constGrid.HEADER.CAPTION_TYPE_FIELD),
                    //this.$constGrid.HEADER.getHeader(5,'Variabile',50,'var', this.$constGrid.HEADER.CAPTION_TYPE_FIELD),
                    this.$constGrid.HEADER.getHeader(6,'action',50,null, this.$constGrid.HEADER.CAPTION_TYPE_ACTION, false, false, false)
                ],
	            actionButtonHeader: [
                	//this.$constGrid.getActionButton(7, 'Altceva din functie', 'altCeca', this.$constGrid.getIcon('fas','skull', '#adad00')),
                    this.$constGrid.getActionButton(8, 'Print din functie', 'invoicePrint', this.$constGrid.ICON_PRINT)
                    //this.$constGrid.getActionButton(9, 'Edit din functie', 'deleteCeva', this.$constGrid.ICON_DELETE),
                    //this.$constGrid.getActionButton(10, 'Delete din functie', 'editCeva', this.$constGrid.ICON_EDIT)
                ],
                returnField: ['name', 'description'],             // return field and edit when selected row
                cfg: {
	                width: 780,
                    height: 350,
                    urlData: 'gridDataTest'
                },
                toolbar: {
                	show: true,
	                fieldShow: {
                		field: ['name'],        // shon on selection with mouse or keyboard
                        separator: " ",
                        includeIdPk: true
                    },
                	actionButton : [
		                // this.$constGrid.getActionButton( null,  'Print din functie', 'invoicePrintToolbar', this.$constGrid.ICON_PRINT),
		                this.$constGrid.getActionButton( null,  'Edit din functie',   'deleteCevaToolbar', this.$constGrid.ICON_DELETE),
		                this.$constGrid.getActionButton( null,  'Delete din functie', 'editCevaToolbar', this.$constGrid.ICON_EDIT)
                    ]
                },
                paginate: {
                	nrButtonShow: 5,
	                recordsPerPage: 10
                }
            }
        },
        mounted() {
            // console.log(this.$refs.gridPrint);
        },
        methods: {
            invoicePrint: function (selectData) {
                //console.log('acum printez');
                //const reqObject = this.$app.getObjectReturnComponent(selectData);
                //console.log(reqObject);
            },
            editCeva: function () {
                console.log('editez ceva');
            },
	        deleteCevaToolbar: function (selectData){
		        console.log('delete de la toolbar');
            },
            editCevaToolbar: function (selectData){
                this.$refs.refGridEdit.showForm(this.$refs.refGridPrint, selectData, this.$constGrid.SQL_UPDATE);
            },
	        emitUpdateGrid: function (actionForm, post) {

            	let externalFiltering = null;

		        this.$refs.gridPrint.refreshGrid(actionForm, externalFiltering);
                console.log('date din grid au fost modificate = ' + actionForm, post);
	        }
        },
        data() {
            return {}
        }
    }
</script>

<style scoped></style>
