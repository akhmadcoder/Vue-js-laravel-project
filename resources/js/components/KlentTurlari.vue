<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Klent Turlari</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Yangi Tur qo'shish
                  <i class="fas fa-plus-square fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Klent Turi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="category in categories" :key="category.id">
                      <td>{{category.id}}</td>
                      <td>{{category.name}}</td>
                      <td>
                          <a href="#" @click="editModal(category)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteCategory(category.id)">
                            <i class="fa fa-trash" style="color:red"></i>
                          </a>
                      </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

<!-- Modal -->
<div class="modal fade" id="addEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Yangi Klent Turini qoshish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Klent Turini o'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateCategory() : createCategory()">
      <div class="modal-body">
        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="Klent turini kiriting"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button v-if="!editmode" type="submit" class="btn btn-primary">Qo'shish</button>
        <button v-if="editmode" type="submit" class="btn btn-primary">O'zgartirish</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
</template>

<script>
    export default {
        data(){

            return{
                editmode: false,
                categories: {},
                form: new Form({
                    id: '',
                    name: '',
                })
            }

        }, 
        methods:{

            editModal(category){
                this.editmode = true
                this.form.reset()
                $('#addEditModal').modal('show')
                this.form.fill(category)
            },

            deleteCategory(id){

                swal.fire({
                    title: 'Ochirmoqchimisiz?',
                    text: "Ochirilgan narsa qayta tiklanmaydi!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xa, ochir!'
                  }).then((result) => {

                    if(result.value){

                      // send request to the server
                      axios.post('api/deleteclientcategory/', {
                          id: id
                        })
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Nom muvaffaqiyatli ochirildi.',
                            'success'
                          )

                        }
                        
                        if(response.data.status === 'error')
                        {
                            swal.fire({
                              icon: 'error',
                              title: 'Oops...',
                              text: 'Qandaydir Xatolik Boldi!',
                              footer: 'Xato: '+response.data.message
                            })
                        }

                      }).catch(()=>{

                          swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Qandaydir Xatolik Boldi!',
                            footer: 'Xato: '
                          })

                      });

                    }

                    
                    
                  })

            },

            loadCategories(){
                axios.get('api/clientcategories').then(({ data }) => (this.categories = data.categories));
            },

            updateCategory(){
                this.form.post('api/updateclientcategory/', {
                  id: this.form.id
                })
                .then(function(response){

                $('#addEditModal').modal('hide')
                if(response.data.status === 'success')
                {
                  Reload.$emit('ReloadContent');
                  swal.fire(
                    'Updated!',
                    'Klent Turi muvaffaqiyatli ozgartirildi.',
                    'success'
                  )

                }
                
                if(response.data.status === 'error')
                {
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                      footer: 'Xato: '+response.data.message
                    })
                }


                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                      footer: 'Xato: '
                    })
                })

            },

            createCategory(){
                this.form.post('api/addclientcaregory')
                .then(function(response){

                $('#addEditModal').modal('hide')
                if(response.data.status === 'success')
                {
                  Reload.$emit('ReloadContent')
                  swal.fire(
                    'Created!',
                    'Yangi tur qoshildi.',
                    'success'
                  )

                }
                
                if(response.data.status === 'error')
                {
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                      footer: 'Xato: '+response.data.message
                    })
                }


                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                      footer: 'Xato: '
                    })
                })

            },

            newModal(){
                this.editmode = false
                this.form.reset()
                $('#addEditModal').modal('show')
            },

        },
        mounted() {
            this.loadCategories()

            Reload.$on('ReloadContent', () => {
                this.loadCategories();
            });

        }
    }
</script>
