<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Xom Ashyo</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-block btn-primary" @click="newModal">Xom Ashyo Qo'shish
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
                      <th>O'lchovi</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="rawmaterial in rawmaterials" :key="rawmaterial.id">
                      <td>{{rawmaterial.id}}</td>
                      <td>{{rawmaterial.name}}</td>
                      <td>{{rawmaterial.measure.name}}</td>
                      <td>
                          <a href="#" @click="editModal(rawmaterial)">
                            <i class="fa fa-edit"></i>
                          </a>
                           | 
                          <a href="#" @click="deleteRawmaterial(rawmaterial.id)">
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
        <h5 v-if="!editmode" class="modal-title" id="exampleModalLabel">Xom Ashyo Qo'shish</h5>
        <h5 v-if="editmode" class="modal-title" id="exampleModalLabel">Xom Ashyoni Ozgartirish</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateRawMaterial() : createRawMaterial()">
      <div class="modal-body">
        <div class="form-group">
          <input v-model="form.name" type="text" name="name" 
            placeholder="Xom Ashyo Nomi"
            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
          <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
          <select v-model="form.measure_id" name="measure_id" id="measure_id" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('measure_id') }">
            <option value="">O'lchovlar</option>
            <option v-for="measure in measures" :key="measure.id" :value="measure.id">{{measure.name}}</option>
          </select>
          <has-error :form="form" field="measure_id"></has-error>
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
                measures: {},
                rawmaterials: {},
                form: new Form({
                    id: '',
                    name: '',
                    measure_id: '',
                })

            }

        },

        methods:{
            deleteRawmaterial(id){
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
                      this.form.delete('api/rawmaterials/'+id)
                      .then(function(response){

                        if(response.data.status === 'success')
                        {
                          Reload.$emit('ReloadContent')
                          swal.fire(
                            'Deleted!',
                            'Xom Ashyo muvaffaqiyatli ochirildi.',
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

            editModal(rawmaterial){
                this.editmode = true
                $('#addEditModal').modal('show')
                this.form.fill(rawmaterial)
            },

            updateRawMaterial(){
                this.form.put('api/rawmaterials/'+this.form.id)
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent');
                      swal.fire(
                        'Updated!',
                        'Xom Ashyo muvaffaqiyatli ozgartirildi.',
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

            createRawMaterial(){
                this.form.post('api/rawmaterials')
                .then(function(response){

                    $('#addEditModal').modal('hide')
                    if(response.data.status === 'success')
                    {
                      Reload.$emit('ReloadContent')
                      swal.fire(
                        'Created!',
                        'Yangi Xom Ashyo qoshildi.',
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
                
            loadRawMaterials(){
                axios.get('api/rawmaterials')
                    .then(({ data }) => (
                        this.rawmaterials = data.rawmaterials,
                        this.measures = data.measures
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

            newModal(){
                this.editmode = false
                $('#addEditModal').modal('show')
                this.form.reset()
            },

        },

        mounted() {
            this.loadRawMaterials()

            Reload.$on('ReloadContent', () => {
                this.loadRawMaterials();
            });
        }
    }
</script>
