<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Maxsulot Turlari</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Maxsulot Turi Qo'shish
                  <i class="fas fa-plus-square fa-faw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Nomi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="producttype in producttypes" :key="producttype.id">
                      <td>{{producttype.id}}</td>
                      <td>{{producttype.name}}</td>
                      <td>
                        <a href="#" @click="editModal(producttype)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteProducttype(producttype.id)">
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
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Maxsulot Turi Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Maxsulot Turini O'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateProductType() : createProductType()">
      <div class="modal-body">
        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="Maxsulot Turi Nomi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Yopish</button>
        <button v-if="!editmode" type="submit" class="btn btn-primary">Saqlash</button>
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
                producttypes: {},
                form: new Form({
                    id: '',
                    name: '',
                })

            }

        },

        methods:{
            deleteProducttype(id){
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
                      this.form.delete('api/producttypes/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Maxsulot Turi muvaffaqiyatli ochirildi.',
                            'success'
                          )

                        }

                      })
                      .catch(()=>{

                          swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Qandaydir Xatolik Boldi!',
                          })

                      });

                    }
                  })
            },

            editModal(producttype){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(producttype)
            },

            loadProductTypes(){
                axios.get('api/producttypes')
                    .then(({ data }) => (
                        this.producttypes = data.producttypes
                    ))
                    .catch(()=>{

                        // if failed
                        swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Qandaydir Xatolik Boldi!',
                        })
                    });
            },

            updateProductType(){
                this.form.put('api/producttypes/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Maxsulot Turi muvaffaqiyatli ozgartirildi.',
                        'success'
                      )
                    }
                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                })
            }, 

            createProductType(){
                this.form.post('api/producttypes')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Maxsulot Turi qoshildi.',
                        'success'
                      )

                    }
                    
                })
                .catch(()=>{

                    // if failed
                    swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Qandaydir Xatolik Boldi!',
                    })
                })

            },

            newModal(){
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },

        mounted() {
            this.loadProductTypes()

            Reload.$on('ReloadContent', () => {
                this.loadProductTypes();
            });

        }
    }
</script>
