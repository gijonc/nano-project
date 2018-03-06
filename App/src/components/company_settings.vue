<template>
  <div class="com_set container">
    <h3>Nano {{ currentTable }} Table</h3>

    <div class="text-left">
      <!-- Button to Open the Modal -->
      <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#editEntryModel">
        + Add New Entry
      </button>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="editEntryModel">
      <div class="modal-dialog modal-lg">
        <div class="modal-content container">

          <!-- Modal Header -->
          <div class="modal-header">
            <h5 v-if="!cur_entry.ID">Creat New entry to {{ currentTable }}</h5>
            <h5 v-if="cur_entry.ID">Editing Entry ID#: <span style="color: red">{{ cur_entry.ID }}</span></h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body text-left">
              <div class="form-group ">
                <label class="text-uppercase">Company</label>
                <input type="text" class="form-control" v-model="cur_entry.Company" placeholder="Company">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Company Code</label>
                <input type="text" class="form-control" v-model="cur_entry.Company_Code" placeholder="Company Code">
              </div>
              <div class="form-group ">
                <label class="text-uppercase">Company's Chinese Name</label>
                <input type="text" class="form-control" v-model="cur_entry.Company_Chinese_Name" placeholder="Company">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Company Address1</label>
                <input type="text" class="form-control" v-model="cur_entry.Company_Address1" placeholder="Company Address 1">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Company Address 2</label>
                <input type="text" class="form-control" v-model="cur_entry.Company_Address2" placeholder="Company Address 2">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Company Address 3</label>
                <input type="text" class="form-control" v-model="cur_entry.Company_Address3" placeholder="Company Address 3">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Contact Person</label>
                <input type="text" class="form-control" v-model="cur_entry.Contact_Person" placeholder="Contact Person">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Contact Person Email</label>
                <input type="email" class="form-control" v-model="cur_entry.Contact_Person_eMail" placeholder="Contact Person Email">
              </div>
              <div class="form-group">
                <label class="text-uppercase">Contact Person Phone#</label>
                <input type="number" class="form-control" v-model="cur_entry.Contact_Person_Tel" placeholder="Contact Person Phone#">
              </div>
                
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button v-if="!cur_entry.ID" v-on:click="createEntry" type="button" class="btn btn-success">Submit</button>
            <button v-if="cur_entry.ID" v-on:click="editEntry" type="button" class="btn btn-warning">Save Changes</button>
          </div>

        </div>
      </div>
    </div>

    <!-- The Modal -->
    <div class="modal fade" id="deleteEntryModel">
      <div class="modal-dialog">
        <div class="modal-content">

          <!-- Modal body -->
          <div class="modal-body text-left">
            <h5 v-if="cur_entry.ID">Are you sure to delete ID <span style="color: red">{{ cur_entry.ID }} </span>from data?</h5>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button data-dismiss="modal" type="button" class="btn btn-secondary btn-sm">Cancel</button>
            <button v-on:click="deleteEntry" type="button" class="btn btn-danger btn-sm">Delete</button>
          </div>
        </div>
      </div>
    </div>


    <br>
    <table>
      <thead>
        <tr>
          <th> </th>
          <th v-for="key in tableHeader">
            {{ key }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="entry in tableData">
          <td>
            <button class="btn btn-sm btn-outline-primary" v-on:click="editEntryTrigger(entry)">Edit</button>
            <button class="btn btn-sm btn-outline-danger" v-on:click="deleteEntryTrigger(entry)">Del</button>
          </td>
          <td v-for="key in tableHeader">
            {{entry[key]}}
          </td>
        </tr>
      </tbody>
    </table>


  </div>
</template>


<script>
// import Nav from './Nav';
// import { isLoggedIn } from '../../utils/auth';
import { Company_Settings } from '../../utils/company_settings-api';

let cs = new Company_Settings;

export default {
	name: 'company_settings',

	components: {

	},

	props: {
		NAME: 'Company Settings',
	},  

	data() {
		return {
			currentTable: 'Company Settings',
			tableData: {},
			tableHeader: {},
			cur_entry: {
        Company:'',
        Company_Code:'',
        Company_Chinese_Name:'',
        Company_Address1:'',
        Company_Address2:'',
        Company_Address3:'',
        Contact_Person:'',
        Contact_Person_eMail:'',
        Contact_Person_Tel:''
      }
		}
	},

	methods: {
		// isLoggedIn() {
		// 	return isLoggedIn();
		// },
			    // helpers
			filterModel: function(obj){
				for (var item in obj){
					this.cur_entry[item] = '';
				}

			},

    	readEntry() {
				cs.readEntry().then((data) => {
					this.tableData = data;
					this.tableHeader = Object.keys(this.tableData[0]);
				});
			},
			
			createEntry() {
				cs.createEntry(this.cur_entry).then((data) => {
					if (data.created === 1){

              //reload data
              this.filterModel(this.cur_entry);
              this.readEntry();
              alert("entry added")
					} else {
						alert("added failed" + data);
					}
					
					$("#editEntryModel").modal("hide");

				}, function(response) {
					// error
					alert("error adding entry");
				});
			},

			editEntryTrigger: function(entry){
				var seleted = entry;
				for (var item in seleted){
					this.cur_entry[item] = seleted[item];
				}
				$("#editEntryModel").modal();
			},

			editEntry() {
				//TODO: check empty input
					cs.editEntry(this.cur_entry).then((data) => {
							if (data.updated === 1){

								//reload data
								this.filterModel(this.cur_entry);
								this.readEntry();
								alert("entry updated");
							} else {
								alert("updated failed" + data);
							}
							$("#editEntryModel").modal("hide");
					}, function(response) {
							// error
							alert("error update entry");
					}
				);
			},

			deleteEntryTrigger: function (entry) {
				var seleted = entry;
				for (var item in seleted){
					this.cur_entry[item] = seleted[item];
				}
				$("#deleteEntryModel").modal();
			},

    deleteEntry: function() {
      cs.deleteEntry(this.cur_entry).then((data) => {
            if (data.deleted === 1){
              //reload data
              this.filterModel(this.cur_entry);
              this.readEntry();
              alert("entry deleted")
            } else {
              alert("deleted failed" + data);
            }
            $("#deleteEntryModel").modal("hide");
        }, function(response) {
            // error
            alert("error delete entry");
        }
      );
    },


  	},
	  
		mounted() {
    	this.readEntry();
  	},

}

</script>


<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

table {
  border-radius: 3px;
}

th {
  border: 1px solid black;
  background-color: grey;
  font-size: 12pt;
  color: white;
  padding: 12px 4px;
}

td {
  border: 1px solid black;
  background-color: #f9f9f9;
  font-size: 10pt;
  padding: 4px 4px;
}

</style>