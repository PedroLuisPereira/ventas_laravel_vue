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
        >Agregar Categoria</button>
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
          placeholder="Burcar..."
        />
      </div>
    </div>
    <hr />

    <h1>Administración de Categorías</h1>

    <!-- tabla -->
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Nombre</th>
          <th scope="col">Descripción</th>
          <th scope="col">Estado</th>
          <th scope="col">Editar</th>
          <th scope="col">Eliminiar</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in categorias" :key="item.id">
          <th v-text="item.nombre"></th>
          <td v-text="item.descripcion"></td>
          <td>
            <div v-if="item.condicion">
              <span class="badge badge-success">Activo</span>
            </div>
            <div v-else>
              <span class="badge badge-danger">Desactivado</span>
            </div>
          </td>

          <td>
            <button class="btn btn-info" v-on:click="abrirModal(item)">Editar</button>
          </td>

          <td>
            <div v-if="item.condicion==1">
              <button class="btn btn-danger" v-on:click="abrirModalConfirmar(item)">Eliminiar</button>
            </div>
            <div v-if="item.condicion==0">
              <button class="btn btn-primary" v-on:click="activar(item)">Activar</button>
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
        <li class="page-item" v-if="paginate.current_page > 1">
          <button
            class="page-link"
            href="#"
            @click.prevent="changePage(paginate.current_page-1)"
          >Previous</button>
        </li>

        <li
          class="page-item"
          v-for="page in pagesNumber"
          :key="page"
          v-bind:class="[page == isActivo ? 'active':'' ]"
        >
          <button class="page-link"  @click.prevent="changePage(page)">{{page}}</button>
        </li>

        <li class="page-item" v-if="paginate.current_page < paginate.last_page">
          <button class="page-link" href="#" @click.prevent="changePage(paginate.current_page+1)">Next</button>
        </li>
      </ul>
    </nav>
    <!-- fin paginacion -->

    <!-- Modal nuevo -->
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2>Nueva Categoría</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Nombre:</label>
                <input
                  type="text" max="50"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Descripción:</label>
                <input
                  type="text"
                  v-model="descripcion"
                  max="256"
                  class="form-control"
                  placeholder="Descripcion"
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
            <h2>Actualizar Categoría</h2>
          </div>
          <div class="modal-body">
            <div class="form-row">
              <div class="form-group col-md-12">
                <input type="hidden" v-model="id" />
                <label>Nombre:</label>
                <input
                  type="text"
                  max="50"
                  v-model="nombre"
                  class="form-control"
                  placeholder="Nombre"
                />
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label>Descripción:</label>
                <input
                  type="text"
                  max="256"
                  v-model="descripcion"
                  class="form-control"
                  placeholder="Descripcion"
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
                :disabled="isDisabled"
                v-on:click="update()"
                class="btn btn-success"
              >Actualizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--fin Modal nuevo / editar cliente -->

    <!-- Modal Desactivar -->
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
      descripcion: "",
      condicion: "",
      categorias: [],
      valorBuscar: "",
      //propiedad de la paginacion 
      paginate: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      }
    };
  },
  methods: {
    consultar(page) {
      var url = "/categoria?page=" + page + "&buscar=" + this.valorBuscar;
      axios
        //.get("/categoria?buscar=" + this.valorBuscar)
        .get(url)
        .then(
          response => (
            (this.categorias = response.data.categorias.data),
            (this.paginate = response.data.paginate)
          )
        );
    },

    create() {
        //enviar peticion
        axios
          .post("/categoria", {
            nombre: this.nombre,
            descripcion: this.descripcion
            //obtener respuesta
          })
          .then(function(response) {
            console.log(response);
          })
          .catch(function(error) {
            console.log(error);
          });

        //llamar al metodo cancelar
        this.cancelar();

        //realizar nuevamente la consulta
        this.consultar();
      
    },

    update() {
        //enviar peticion
        axios
          .put("/categoria/" + this.id, {
            id: this.id,
            nombre: this.nombre,
            descripcion: this.descripcion
          })
          .then(function(response) {
            console.log(response);
          })
          .catch(function(error) {
            console.log(error);
          });

        //llamar al metodo cancelar  
        this.cancelar();

        //realizar nuevamente la consulta
        this.consultar();
    },

    borrar() {
      //enviar peticion
      axios
        .delete("/categoria/" + this.id, { params: { id: this.id } })
        .then(response => console.log(response.data));
      
      //llamar al metodo cancelar
      this.cancelar();

      //realizar nuevamente la consulta
      this.consultar();
    },

    //abrir modal confirmar
    abrirModalConfirmar(categoria) {
      this.id = categoria.id;
      $("#ModalConfirmarBorrar").modal("show");
    },

    
    activar(categoria) {
      this.id = categoria.id;
      this.borrar();
    },

    
    cancelar() {
      //colocar valores en blanco
      this.nombre = "";
      this.descripcion = "";
      this.mensaje = "";
    
      //cerrar los modal
      $("#modalCreate").modal("hide");
      $("#modalUpdate").modal("hide");
      $("#ModalConfirmarBorrar").modal("hide");
    },

        
    abrirModal(categoria) {

      //colocar valores en blanco
      this.id = categoria.id;
      this.nombre = categoria.nombre;
      this.descripcion = categoria.descripcion;

      //cerrar el modal
      $("#modalUpdate").modal("show");
    },
    
    //metodo de la paginacion 
    changePage: function(page) {
      this.paginate.current_page = page;
      this.consultar(page);
    }
  },

  computed: {
    //metodo de la paginacion 
    isDisabled: function() {
      if (this.nombre == "") {
        return true;
      } else {
        return false;
      }
    },
    //metodo de la paginacion 
    isActivo: function() {
      return this.paginate.current_page;
    },
    //metodo de la paginacion 
    pagesNumber: function() {
      if (!this.paginate.to) {
        return [];
      }
      var from = this.paginate.current_page - 2;
      if (from < 1) {
        from = 1;
      }

      var to = from + 2 * 2;
      if (to >= this.paginate.last_page) {
        to = this.paginate.last_page;
      }

      var pagesArray = [];

      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    }
  },

  mounted() {
    this.consultar();
  }
};
</script>


