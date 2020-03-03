<template>
    <div class="container">
        
        <div class="row mt-3">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">O'lchovlar</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Yangi O'lchov qo'shish
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
                    <tr v-for="measure in measures" :key="measure.id">
                      <td>{{measure.id}}</td>
                      <td>{{measure.name}}</td>
                      <td>
                      <a href="#" @click="editModal(measure)">
                        <i class="fa fa-edit"></i>
                      </a>
                       | 
                      <a href="#" @click="deleteMeasure(measure.id)">
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
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">O'lchov qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">O'lchov nomini o'zgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateMeasure() : createMeasure()">
          <div class="modal-body">

        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="O'lchov nomini kiriting"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button v-if="editmode" type="submit" class="btn btn-success">O'zgartirish</button>
            <button v-if="!editmode" type="submit" class="btn btn-primary">Qo'shish</button>
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
                measures: {},
                form: new Form({
                    id: '',
                    name: '',
                })
            }

        },

        methods: {

            updateMeasure(){
                this.form.put('api/sozlamalar/'+this.form.id)
                .then(function(response){

                $('#addEditModal').modal('hide')
                if(response.data.status === 'success')
                {
                  Reload.$emit('ReloadContent');
                  swal.fire(
                    'Updated!',
                    'Olchov muvaffaqiyatli ozgartirildi.',
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

            loadMeasures(){
                axios.get('api/sozlamalar').then(({ data }) => (this.measures = data.measures));
            },

            editModal(measure){
                this.editmode = true
                this.form.reset()
                $('#addEditModal').modal('show')
                this.form.fill(measure)
            },

            deleteMeasure(id){

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
                      this.form.delete('api/sozlamalar/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent');
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

            createMeasure(){

                this.form.post('api/sozlamalar')
                .then(function(response){

                $('#addEditModal').modal('hide')
                if(response.data.status === 'success')
                {
                  Reload.$emit('ReloadContent');
                  swal.fire(
                    'Created!',
                    'Yangi olchov qoshildi.',
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
            this.loadMeasures()
            
            Reload.$on('ReloadContent', () => {
                this.loadMeasures();
            });
        }

    }
</script>
