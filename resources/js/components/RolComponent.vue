<template>
  <div>
    <hr />
    <div class="row">
      <div class="col">
        <button
          type="button"
          data-toggle="modal"
          data-target="#modalCreate"
          class="btn btn-success"
          disabled
        >Agregar Nuevo Rol</button>
      </div>
      <div class="col">
        <p></p>
      </div>
      <div class="col">
        <input
          type="search"
          name="buscar"
          v-on:keyup="consultar()"
          v-model="valorBuscar"
          class="form-control"
          placeholder="Buscar..."
          id
        />
      </div>
    </div>
    <hr />

    <h1>Administración de Roles</h1>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Descripcion</th>
          <th scope="col">Estado</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in datos" :key="item.id">
          <td v-text="item.nombre"></td>
          <td v-text="item.descripcion"></td>
          <td>
            <div v-if="item.condicion">
              <span class="badge badge-success">Activo</span>
            </div>
            <div v-else>
              <span class="badge badge-danger">Desactivado</span>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <hr />
    <!-- fin tabla -->

    <!-- paginacion  -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#">Previous</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">1</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">2</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">3</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#">Next</a>
        </li>
      </ul>
    </nav>
    <!-- fin paginacion -->

    <!-- Modal nuevo -->
    <!-- <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nuevo Proveedor</h2>
          </div>
          <div class="modal-body">
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input
                  type="text"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Tipo de Documento</label>
                <select class="form-control" v-model="tipo_documento">
                  <option value="">Seleccionar...</option>
                  <option value="Cédula" >Cédula</option>
                  <option value="NIT" >NIT</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Número de Documento</label>
                <input  type="text" v-model="nume_documento" class="form-control" placeholder="Número de Documento"/>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Direccion</label>
                <input type="text" v-model="direccion" class="form-control" placeholder="Direccion" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Teléfono</label>
                <input
                  type="text"
                  v-model="telefono"
                  class="form-control"
                  placeholder="Telefono"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Email</label>
                <input
                  type="email"
                  v-model="email"
                  class="form-control"
                  placeholder="email"
                />
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Contacto</label>
                <input
                  type="text"
                  v-model="contacto"
                  class="form-control"
                  placeholder="contacto"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Teléfono Contacto</label>
                <input
                  type="tel"
                  v-model="telefono_contacto"
                  class="form-control"
                  placeholder="Teléfono Contacto"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                data-dismiss="modal"
                v-on:click="cancelar()"
                class="btn btn-secondary"
              >Cancelar</button>

              <button
                type="button"
                id="Agregar"
                :disabled="isDisabled"
                v-on:click="create()"
                class="btn btn-success"
              >Agregar</button>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!--fin Modal nuevo / editar cliente -->

    <!-- Modal editar -->
    <!-- <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Actualizar Proveedor</h2>
          </div>
          <div class="modal-body">
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input
                  type="text"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Tipo de Documento</label>
                <select class="form-control" v-model="tipo_documento">
                  <option value="">Seleccionar...</option>
                  <option value="Cédula" >Cédula</option>
                  <option value="NIT" >NIT</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Número de Documento</label>
                <input  type="text" v-model="nume_documento" class="form-control" placeholder="Número de Documento"/>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Direccion</label>
                <input type="text" v-model="direccion" class="form-control" placeholder="Direccion" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Teléfono</label>
                <input
                  type="text"
                  v-model="telefono"
                  class="form-control"
                  placeholder="Telefono"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Email</label>
                <input
                  type="email"
                  v-model="email"
                  class="form-control"
                  placeholder="email"
                />
              </div>
            </div>
            
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Contacto</label>
                <input
                  type="text"
                  v-model="contacto"
                  class="form-control"
                  placeholder="contacto"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Teléfono Contacto</label>
                <input
                  type="tel"
                  v-model="telefono_contacto"
                  class="form-control"
                  placeholder="Teléfono Contacto"
                />
              </div>
            </div>

            <div class="modal-footer">
              <button
                type="button"
                data-dismiss="modal"
                v-on:click="cancelar()"
                class="btn btn-secondary"
              >Cancelar</button>

              <button
                type="button"
                id="Agregar"
                :disabled="isDisabled"
                v-on:click="update()"
                class="btn btn-success"
              >Actualizar</button>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!--fin Modal editar -->

    <!-- ModalConfirmarCancelar -->
    <!-- <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="max-width: 600px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1>Realmente quiere borrarlo?</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              data-dismiss="modal"
              v-on:click="cancelar()"
              class="btn btn-secondary"
            >Cancelar</button>
            <button
              type="button"
              id="btnConfirmarBorrado"
              v-on:click="borrar()"
              class="btn btn-success"
            >Confirmar</button>
          </div>
        </div>
      </div>
    </div> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      nombre:'',
      descripcion:'',
      condicion:'',
      valorBuscar: "",
      datos: []
    };
  },
  methods: {
    consultar() {
      axios
        .get("/rol?buscar=" + this.valorBuscar)
        .then(response => (this.datos = response.data));
    },

    create() {
      //enviar peticion
      axios
        .post("/rol", {
          
        })
        .then(function(response) {
          //obtener respuesta
          console.log(response);
        })
        .catch(function(error) {
          //ver errores
          console.log(error);
        });

      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    update() {
      //enviar peticion
      axios
        .put("/rol/" + this.id, {
          
        })
        //respuesta del servidor
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          //ver errores
          console.log(error);
        });

      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    borrar() {
      //enviar peticion
      axios
        .delete("/rol/" + this.id, { params: { id: this.id } })
        .then(response => console.log(response.data));

      //llamar al metodo cancelar
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    //abrir modal confirmar
    abrirModalConfirmar(objeto) {
      this.id = objeto.id;
      $("#ModalConfirmarBorrar").modal("show");
    },

    cancelar() {
      //colocar valores en blanco
      

      //cerrar los modales
      $("#modalCreate").modal("hide");
      $("#modalUpdate").modal("hide");
      $("#ModalConfirmarBorrar").modal("hide");
    },

    abrirModal(objeto) {
      //colocar valores
      

      //mostrar modal
      $("#modalUpdate").modal("show");
    }
  },

  computed: {
    isDisabled: function() {
      
    }
  },

  mounted() {
    //realizar las consultas al cargar el componente
    this.consultar();
  }
};
</script>


