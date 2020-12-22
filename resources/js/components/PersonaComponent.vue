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
        >Agregar Cliente</button>
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

    <h1>Administración de Clientes</h1>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Tipo Documento</th>
          <th scope="col">Numero Documento</th>
          <th scope="col">Dirección</th>
          <th scope="col">Teléfono</th>
          <th scope="col">Email</th>
          <th scope="col">Editar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in datos" :key="item.id">
          <th v-text="item.nombre"></th>
          <th v-text="item.tipo_documento"></th>
          <th v-text="item.numero_documento"></th>
          <th v-text="item.direccion"></th>
          <td v-text="item.telefono"></td>
          <td v-text="item.email"></td>
          <td>
            <button class="btn btn-info" v-on:click="abrirModal(item)">Editar</button>
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
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nuevo Cliente</h2>
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
                  max="100"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Tipo de Documento</label>
                <select class="form-control" v-model="tipo_documento">
                  <option value="">Seleccionar...</option>
                  <option value="Cedula" >Cédula</option>
                  <option value="NIT" >NIT</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Número de Documento</label>
                <input  type="text" v-model="numero_documento" class="form-control" max="20" placeholder="Número de Documento"/>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Direccion</label>
                <input type="text" v-model="direccion" class="form-control" max="70" placeholder="Direccion" />
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
                  max="20"
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
                  max="50"
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
    </div>
    <!--fin Modal nuevo / editar cliente -->

    <!-- Modal editar -->
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nuevo Cliente</h2>
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
                  max="100"
                />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Tipo de Documento</label>
                <select class="form-control" v-model="tipo_documento">
                  <option value="0">Seleccionar...</option>
                  <option value="Cedula" >Cédula</option>
                  <option value="NIT" >NIT</option>
                </select>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Número de Documento</label>
                <input  type="text" v-model="numero_documento" class="form-control" max="20" placeholder="Número de Documento"/>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Direccion</label>
                <input type="text" v-model="direccion" class="form-control" placeholder="Direccion" max="70" />
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
                  max="20"
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
                  max="50"
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
    </div>
    <!--fin Modal editar -->

    <!-- ModalConfirmarCancelar -->
    <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
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
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      id: "",
      nombre: "",
      tipo_documento: "",
      numero_documento: "",
      direccion: "",
      telefono: "",
      email: "",
      valorBuscar: "",
      datos: []
    };
  },
  methods: {
    consultar() {
      axios
        .get("/persona?buscar=" + this.valorBuscar)
        .then(response => (this.datos = response.data));
    },

    create() {
      axios
        .post("/persona", {
          nombre: this.nombre,
          tipo_documento: this.tipo_documento,
          numero_documento: this.numero_documento,
          direccion: this.direccion,
          telefono: this.telefono,
          email: this.email
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    update() {
      axios
        .put("/persona/" + this.id, {
          id: this.id,
          nombre: this.nombre,
          tipo_documento: this.tipo_documento,
          numero_documento: this.numero_documento,
          direccion: this.direccion,
          telefono: this.telefono,
          email: this.email
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    borrar() {
      axios
        .delete("/persona/" + this.id, { params: { id: this.id } })
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
      this.id = "";
      this.nombre = "";
      this.tipo_documento = "";
      this.numero_documento = "";
      this.direccion = "";
      this.telefono = "";
      this.email = "";

      //cerrar los modales
      $("#modalCreate").modal("hide");
      $("#modalUpdate").modal("hide");
      $("#ModalConfirmarBorrar").modal("hide");
    },

    abrirModal(objeto) {
      //colocar valores
      this.id = objeto.id;
      this.nombre = objeto.nombre;
      this.tipo_documento = objeto.tipo_documento;
      this.numero_documento = objeto.numero_documento;
      this.direccion = objeto.direccion;
      this.telefono = objeto.telefono;
      this.email = objeto.email;

      //mostrar modal
      $("#modalUpdate").modal("show");
    }
  },

  computed: {
    isDisabled: function() {
      if (this.nombre == "" || this.tipo_documento =='' || this.numero_documento =='') {
        return true;
      } else {
        return false;
      }
    }
  },

  mounted() {
    //realizar las consultas al cargar el componente
    this.consultar();
  }
};
</script>


