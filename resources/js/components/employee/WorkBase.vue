<template>
    <section class="content">
      <div class="container-fluid">
          <div class="row">
  
            <div class="col-12">
            
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">List of Work Base</h3>
  
                  <div class="card-tools">
                    
                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Add New
                    </button>
                  </div>
  
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Remarks</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(workbase,index) in workBase.data" :key="workbase.id"> 
                        <td>{{index + 1}}</td>
                        <td>{{workbase.name}}</td>
                        <td>{{workbase.address}}</td>
                        <td>{{workbase.remarks}}</td>
                        <td>
                          <a href="#" @click="editModal(workbase)">
                              <i class="fa fa-edit blue"></i>
                          </a>
                          /
                          <a href="#" @click="deleteWorkbase(workbase.id)">
                              <i class="fa fa-trash red"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <pagination :data="workBase" @pagination-change-page="getResults"></pagination>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
  
          <!-- Modal -->
          <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" v-show="!editmode">Create New Employee</h5>
                      <h5 class="modal-title" v-show="editmode">Edit Employee</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div> 
  
                  <form @submit.prevent="editmode ? updateWorkBase() : createWorkBase()">
                      <div class="modal-body">
                          <div class="form-group">
                              <label>Name</label>
                              <input v-model="form.name" type="text" name="name"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                              <has-error :form="form" field="name"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Address</label>
                              <input v-model="form.address" type="text" name="address"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                              <has-error :form="form" field="address"></has-error>
                          </div>
                          <div class="form-group">
                              <label>Remarks</label>
                              <input v-model="form.email" type="remarks" name="remarks"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('remarks') }">
                              <has-error :form="form" field="remarks"></has-error>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                          <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                      </div>
                    </form>
                  </div>
              </div>
          </div>
      </div>
    </section>
  </template>
  
  <script>
      import VueTagsInput from '@johmun/vue-tags-input';
  
      export default {
        components: {
            VueTagsInput,
          },
          data () {
              return {
                  editmode: false,
                  workBase : {},
                  form: new Form({
                    id:'',
                    address : '',
                    remarks: '',
                    name: '',
                  }),
              }
          },
          methods: {
  
            getResults(page = 1) {
  
                this.$Progress.start();
                
                axios.get('api/workBase?page=' + page).then(({ data }) => (this.employees = data.data));
  
                this.$Progress.finish();
            },
            loadWorkBases(){
  
              // if(this.$gate.isAdmin()){
                axios.get("api/workbase").then(({ data }) => (this.workBase = data.data));              
              // }
            },
            editModal(employee){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(employee);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            createWorkBase(){
                this.$Progress.start();
                this.form.post('api/workbase')
                .then((data)=>{
                  if(data.data.success){
                    $('#addNew').modal('hide');
  
                    Toast.fire({
                          icon: 'success',
                          title: data.data.message
                      });
                    this.$Progress.finish();
                    this.loadWorkBases();
  
                  } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
  
                    this.$Progress.failed();
                  }
                })
                .catch(()=>{
  
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again'
                    });
                })
            },
            updateWorkBase(){
              console.log("form",this.form)
                this.$Progress.start();
                console.log("id",this.form.id)
                this.form.put('api/workbase/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');
  
                    this.loadWorkBases();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
  
            },
            deleteWorkbase(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
  
                        // Send request to the server
                          if (result.value) {
                                this.form.delete('api/workbase/'+id).then(()=>{
                                        Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                    // Fire.$emit('AfterCreate');
                                    this.loadWorkBases();
                                }).catch((data)=> {
                                    Swal.fire("Failed!", data.message, "warning");
                                });
                          }
                    })
            },
  
          },
          mounted() {
              
          },
          created() {
              this.$Progress.start();
  
              this.loadWorkBases();
              // this.loadCategories();
              // this.loadTags();
  
              // this.$Progress.finish();
          },
          filters: {
              truncate: function (text, length, suffix) {
                  return text.substring(0, length) + suffix;
              },
          },
          computed: {
            filteredItems() {
              return this.autocompleteItems.filter(i => {
                return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
              });
            },
          },
      }
  </script>