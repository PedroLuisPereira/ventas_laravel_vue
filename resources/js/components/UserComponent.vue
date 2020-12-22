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
          v-on:click="consultarRol()"
        >Agregar Usuario</button>
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

    <h1>Administración de Usuarios</h1>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Email</th>
          <th scope="col">Rol</th>
          <th scope="col">Estado</th>
          <th scope="col">Editar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in datos" :key="item.id" >
          <th v-text="item.name"></th>
          <td v-text="item.email"></td>
          <td v-text="item.rol_id"></td>
          <td>
            <div v-if="item.condicion">
              <span class="badge badge-success">Activo</span>
            </div>
            <div v-else>
              <span class="badge badge-danger">Desactivado</span>
            </div>
          </td>
          <td>
            <button class="btn btn-info" v-on:click="abrirModalEditar(item)">Editar</button>
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
            <h2>Nuevo Usuario</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input type="text" v-model="name" class="form-control" placeholder="Nombre" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Rol</label>
                <select class="form-control" v-model="rol_id">
                  <option value="">Seleccionar...</option>
                  <option
                    v-for="item in datos1"
                    :key="item.id"
                    v-bind:value="item.id"
                  >{{item.nombre}}</option>
                </select>
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Email</label>
                <input type="email" v-model="email" class="form-control" placeholder="email" />
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Password</label>
                <input
                  type="password"
                  v-model="password"
                  class="form-control"
                  placeholder="Password"
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
            <h2>Actualizar Usuario</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input type="text" v-model="name" class="form-control" placeholder="Nombre" />
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputState">Rol</label>
                <select class="form-control" v-model="rol_id">
                  <option value="0">Seleccionar...</option>
                  <option
                    v-for="item in datos1"
                    :key="item.id"
                    v-bind:value="item.id"
                  >{{item.nombre}}</option>
                </select>
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Email</label>
                <input type="email" v-model="email" class="form-control" placeholder="email" />
              </div>
            </div>


            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Password</label>
                <input
                  type="password"
                  v-model="password"
                  class="form-control"
                  placeholder="Password"
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
      name: "",
      email: "",
      password: "",
      condicion: "",
      rol_id: "",
      valorBuscar: "",
      datos: [],
      datos1: []
    };
  },
  methods: {
    consultar() {
      axios
        .get("/usuario?buscar=" + this.valorBuscar)
        .then(response => (this.datos = response.data));
    },

    consultarRol() {
      axios
        .get("/consultarrol")
        .then(response => (this.datos1 = response.data));
    },

    create() {
      //enviar peticion
      axios
        .post("/usuario", {
          name: this.name,
          email: this.email,
          password: this.password,
          rol_id: this.rol_id
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      //cerrar todo
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    update() {
      //enviar peticion
      axios
        .put("/usuario/" + this.id, {
          id: this.id,
          name: this.name,
          email: this.email,
          password: this.password,
          rol_id: this.rol_id
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      //cerrar todo
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    borrar() {
      //enviar peticion
      axios
        .delete("/usuario/" + this.id, { params: { id: this.id } })
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
      this.name = "";
      this.email = "";
      this.password = "";
      this.condicion = "";
      this.rol_id = "";
      this.valorBuscar = "";
      //cerrar los modales
      $("#modalCreate").modal("hide");
      $("#modalUpdate").modal("hide");
      $("#ModalConfirmarBorrar").modal("hide");
    },

    abrirModalEditar(objeto) {
      //colocar valores
      this.id = objeto.id;
      this.name = objeto.name;
      this.email = objeto.email;
      this.password = "";
      this.condicion = objeto.condicion;
      this.rol_id = objeto.rol_id;

      //consultar roles
      this.consultarRol();
      //mostrar modal
      $("#modalUpdate").modal("show");
    }
  },

  computed: {
    isDisabled: function() {
      if (this.name == "" || this.password == "") {
        return true;
      } else {
        return false;
      }
    }
  },

  mounted() {
    this.consultar();
  }
};
</script>


