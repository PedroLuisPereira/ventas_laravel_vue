<template>
  <div>
    <!-- consulta -->
    <div v-if="compra === 'A'">
      <hr />
      <div class="row">
        <div class="col">
          <button type="button" class="btn btn-success" v-on:click="menuVenta()">Agregar Venta</button>
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

      <h1>Administración de Compras</h1>
      <div>
        <!-- tabla -->
        <table class="table">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Usuario</th>
              <th scope="col">Cliente</th>
              <th scope="col">Tipo Comprobante</th>
              <th scope="col">Serie Comprobante</th>
              <th scope="col">Numero Comprobante</th>
              <th scope="col">Fecha-Hora</th>
              <th scope="col">Descuento</th>
              <th scope="col">Impuesto</th>
              <th scope="col">Total</th>
              <th scope="col">Estado</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in arrayVenta" :key="item.id">
              <th v-text="item.user_id"></th>
              <th v-text="item.persona_id"></th>
              <th v-text="item.tipo_comprobante"></th>
              <th v-text="item.serie_comprobante"></th>
              <th v-text="item.numero_comprobante"></th>
              <td v-text="item.fecha_hora"></td>
              <td v-text="item.descuento"></td>
              <td v-text="item.impuesto"></td>
              <td v-text="item.total"></td>
              <td v-text="item.estado"></td>
              <td>
                <a href="#" class="btn btn-success" v-on:click="abrirModalVer(item)">*</a>
                <a href="#" class="btn btn-danger" v-on:click="abrirModalConfirmar(item)">X</a>
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
      </div>
    </div>
    <!-- fin consulta -->

    <!-- venta -->
    <div v-if="compra === 'B'">
      <button type="button" class="btn btn-secondary" v-on:click="menuVenta()">Cancelar</button>
      <button
        type="button"
        class="btn btn-primary"
        :disabled="isDisabledCreate"
        v-on:click="create()"
      >Registrar Venta</button>
      <hr />

      <!-- seccion cliente -->
      <div class="row">
        <div class="col">
          <label for="proveedor">Cliente</label>
          <select class="form-control" v-model="persona_id">
            <option value>Seleccionar...</option>
            <option
              v-for="item in arrayCliente"
              :key="item.id"
              v-bind:value="item.id"
            >{{item.nombre}}</option>
          </select>
        </div>
        <div class="col">
          <label for="impuesto">Impuesto</label>
          <input type="number" step="any" class="form-control" v-model="impuesto" />
        </div>
      </div>
      <!-- fin seccion cliente -->

      <hr />

      <!-- seccion global  -->
      <div class="row">
        <div class="col">
          <label for="proveedor">Tipo de Comprobante</label>
          <select class="form-control" v-model="tipo_comprobante">
            <option value disabled>Seleccionar...</option>
            <option value="Boleta">Boleta</option>
            <option value="Factura">Factura</option>
          </select>
        </div>
        <div class="col">
          <label for="impuesto">Serie de Comprobante</label>
          <input type="text" class="form-control" v-model="serie_comprobante" />
        </div>
        <div class="col">
          <label for="impuesto">Numero de Comprobante</label>
          <input type="text" class="form-control" v-model="numero_comprobante" />
        </div>
      </div>
      <!-- seccion global  -->

      <hr />
      <!-- seccion articulos -->
      <div class="row">
        <div class="col">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputCity">Codigo del Artículo</label>
              <input
                type="text"
                class="form-control"
                v-model="codigoArticulo"
                placeholder="Código de barras..."
                v-on:keyup="consultarArticulo()"
              />
            </div>

            <div class="form-group col-md-6">
              <label for="inputCity">Nombre de Artículo</label>
              <input type="text" class="form-control" disabled v-model="llenarArticulo" />
            </div>
          </div>
        </div>

        <div class="col">
          <div class="form-row">
            <div class="form-group col-md-5">
              <label for="inputCity">Precio de Venta</label>
              <input type="number" class="form-control" step="any" v-model="precio" />
            </div>
            <div class="form-group col-md-5">
              <label for="inputCity">Cantidad a Vender</label>
              <input type="number" class="form-control" v-model="cantidad" />
            </div>
            <div class="form-group col-md-2">
              <label for="inputZip">.</label>
              <button
                v-on:click="agregarArticulo()"
                :disabled="isDisabled"
                class="btn btn-success"
              >Agregar</button>
            </div>
          </div>
        </div>
      </div>
      <!-- fin seccion articulos -->
      <hr />

      <!-- tabla de detalles -->
      <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Opciones</th>
            <th scope="col">Artículo</th>
            <th scope="col">Precio</th>
            <th scope="col">Cantidad</th>
            <th scope="col">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,indice) in arrayDetalleCompra" :key="item.contador">
            <th>
              <button v-on:click="eliminarArticulo(indice)" class="btn btn-danger">X</button>
            </th>
            <th v-text="item.nombreArticulo"></th>
            <th v-text="item.precio"></th>
            <th v-text="item.cantidad"></th>
            <th v-text="item.subtotal"></th>
          </tr>
          <tr>
            <th>Total Parcial</th>
            <th></th>
            <th></th>
            <th></th>
            <th v-text="totalparcial"></th>
          </tr>
          <tr>
            <th>Total Impuesto</th>
            <th></th>
            <th></th>
            <th></th>
            <th v-text="totalImpuesto"></th>
          </tr>
          <tr>
            <th>Total Neto</th>
            <th></th>
            <th></th>
            <th></th>
            <th v-text="total"></th>
          </tr>
        </tbody>
      </table>
      <!-- fin tabla de detalles -->
    </div>
    <!-- fin Compra -->

    <!-- Modal ver -->
   <div class="modal fade" id="modalVer" tabindex="-1" role="dialog" aria-labelledby="modalVerTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">


              <div class="modal-header">
                  <h5 class="modal-title" id="modalVerTitle">Detalles de la Compra</h5>
                  <button type="button" v-on:click="cerrarModalVer()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              </div>

              <div class="modal-body">
                    <!-- seccion proveedor -->
                    <div class="row">
                      <div class="col">
                        <label for="proveedor">Proveedor</label>
                        <input type="text" class="form-control" v-model="persona_id" />
                      </div>
                      <div class="col">
                        <label for="impuesto">Impuesto</label>
                        <input type="number" step="any" class="form-control" v-model="impuesto" />
                      </div>
                    </div>
                    <!-- fin seccion proveedor -->

                    <hr />

                    <!-- seccion tipo documento  -->
                    <div class="row">
                      <div class="col">
                        <label for="proveedor">Tipo de Comprobante</label>
                        <input type="text" class="form-control" v-model="tipo_comprobante" />
                      </div>
                      <div class="col">
                        <label for="impuesto">Serie de Comprobante</label>
                        <input type="text" class="form-control" v-model="serie_comprobante" />
                      </div>
                      <div class="col">
                        <label for="impuesto">Numero de Comprobante</label>
                        <input type="text" class="form-control" v-model="numero_comprobante" />
                      </div>
                    </div>
                    <!-- seccion tipo documento  -->

                    <hr />

                    <!-- tabla de detalles -->
                    <table class="table">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Código Artículo</th>
                          <th scope="col">Precio</th>
                          <th scope="col">Cantidad</th>
                          <th scope="col">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(item) in arrayDetalles" :key="item.contador">
                          <th v-text="item.articulo_id"></th>
                          <th v-text="item.precio"></th>
                          <th v-text="item.cantidad"></th>
                          <th v-text="item.precio * item.cantidad"></th>
                        </tr>
                        <tr>
                          <th>Total Parcial</th>
                          <th></th>
                          <th></th>
                          <th v-text="totalparcial"></th>
                        </tr>
                        <tr>
                          <th>Total Impuesto</th>
                          <th></th>
                          <th></th>
                          <th v-text="totalImpuesto"></th>
                        </tr>
                        <tr>
                          <th>Total Neto</th>
                          <th></th>
                          <th></th>
                          <th v-text="total"></th>
                        </tr>
                      </tbody>
                    </table>
                    <!-- fin tabla de detalles -->
              </div>

              <div class="modal-footer">
                      <button
                        type="button"
                        class="btn btn-secondary"
                        v-on:click="cerrarModalVer()"
                        data-dismiss="modal"
                      >Cerrar</button>
              </div>
              
        </div>
    </div>
  </div>
    <!--fin Modal ver -->

    <!-- ModalConfirmarCancelar -->
    <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="max-width: 600px" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h1>Realmente quiere anular la compra?</h1>
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
    <!-- fin modal confirmar -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      //campos de compra
      id: "",
      tipo_comprobante: "",
      serie_comprobante: "",
      numero_comprobante: "",
      fecha_hora: "",
      impuesto: 0,
      estado: "",
      persona_id: "",
      user_id: "",
      total: 0,
      totalparcial: 0,
      totalImpuesto: 0,
      //campo abrir seccion de compras
      compra: "A",
      //campos de detalle_compra
      cantidad: 0,
      precio: 0,
      articulo_id: "",
      //campos de articulo
      codigoArticulo: "",
      nombreArticulo: "",
      //array para consulas
      arrayVenta: [],
      arrayCliente: [],
      arrayArticulos: [],
      arrayDetalleCompra: [],
      arrayDetalles: [],
      //valor a buscar
      valorBuscar: ""
    };
  },

  methods: {
    consultarVentas() {
      axios
        .get("/venta?buscar=" + this.valorBuscar)
        .then(response => (this.arrayVenta = response.data));
    },

    consultarDetalles() {
      axios
        .get("/detallecompra?id=" + this.id)
        .then(response => (this.arrayDetalles = response.data));
    },

    consultarCliente() {
      axios
        .get("/persona")
        .then(response => (this.arrayCliente = response.data));
    },

    consultarArticulo() {
      axios
        .get("/consultarArticulo?buscar=" + this.codigoArticulo)
        .then(response => (this.arrayArticulos = response.data));
    },

    agregarArticulo() {
      var elemento = {
        cantidad: this.cantidad,
        precio: this.precio,
        articulo_id: this.articulo_id,
        nombreArticulo: this.nombreArticulo,
        subtotal: this.precio * this.cantidad
      };
      this.total = this.total + this.precio * this.cantidad;
      this.totalImpuesto = this.total * this.impuesto;
      this.totalparcial = this.total - this.totalImpuesto;
      this.arrayDetalleCompra.push(elemento);
      this.articulo_id = "";
      this.precio = 0;
      this.cantidad = 0;
      this.nombreArticulo = "";
      this.codigoArticulo = "";
      this.arrayArticulos = [];
    },

    eliminarArticulo(indice) {
      this.total = this.total - this.arrayDetalleCompra[indice].subtotal;
      this.totalImpuesto = this.total * this.impuesto;
      this.totalparcial = this.total - this.totalImpuesto;
      var removed = this.arrayDetalleCompra.splice(indice, 1);
    },

    create() {
      //enviar peticion
      axios
        .post("/venta", {
          tipo_comprobante: this.tipo_comprobante,
          serie_comprobante: this.serie_comprobante,
          numero_comprobante: this.numero_comprobante,
          impuesto: this.totalImpuesto,
          total: this.total,
          estado: this.estado,
          persona_id: this.persona_id,
          arrayDetalles: this.arrayDetalleCompra
        })
        .then(function(response) {
          console.log(response);
        })
        .catch(function(error) {
          console.log(error);
        });

      //limpiar todo
      this.limpiarCompra();

      //respusta
      alert("Compra registrada");
    },

    abrirModalConfirmar(objeto) {
      this.id = objeto.id;
      $("#ModalConfirmarBorrar").modal("show");
    },

    abrirModalVer(objeto) {
      this.id = objeto.id;
      this.persona_id = objeto.persona_id;
      this.impuesto = objeto.impuesto;
      this.tipo_comprobante = objeto.tipo_comprobante;
      this.serie_comprobante = objeto.serie_comprobante;
      this.numero_comprobante = objeto.numero_comprobante;
      this.total = objeto.total;
      this.totalImpuesto = objeto.impuesto;
      this.totalparcial = this.total - this.impuesto;
      this.consultarDetalles();
      $("#modalVer").modal("show");
    },

    cerrarModalVer() {
      this.id = '';
      this.persona_id = '';
      this.impuesto = 0;
      this.tipo_comprobante = '';
      this.serie_comprobante = '';
      this.numero_comprobante = '';
      this.total = 0;
      this.totalImpuesto = 0;
      this.totalparcial = 0;
      this.arrayDetalles= [],
      $("#modalVer").modal("hide");
    },

    borrar() {
      //enviar peticion
      axios
        .delete("/compra/" + this.id, { params: { id: this.id } })
        .then(response => console.log(response.data));

      //realizar nuevamente la consulta
      //this.limpiarCompra();
    },

    menuVenta() {
      if (this.compra == "A") {
        this.compra = "B";
        //consultar los proveedores
        this.consultarCliente();
      } else {
        this.compra = "A";
        this.consultarVentas();
      }
    },

    limpiarCompra() {
      this.id = "";
      this.tipo_comprobante = "";
      this.serie_comprobante = "";
      this.numero_comprobante = "";
      this.fecha_hora = "";
      this.total = 0;
      this.estado = "";
      this.persona_id = "";
      this.user_id = "";
      this.totalparcial = 0;
      this.totalImpuesto = 0;
      //campos de detalle_compra
      this.cantidad = 0;
      this.precio = 0;
      this.articulo_id = "";
      //campos de articulo
      this.codigoArticulo = "";
      this.nombreArticulo = "";
      //array para consulas
      this.arrayArticulos = [];
      this.arrayDetalleCompra = [];
      $("#ModalConfirmarBorrar").modal("hide");
      this.consultarVentas();
    }
  },

  computed: {
    //validar boton guardar
    isDisabled: function() {
      if (this.cantidad <= 0 || this.precio < 0 || this.articulo_id == "") {
        return true;
      } else {
        return false;
      }
    },

    isDisabledCreate: function() {
      if (
        this.persona_id == "" ||
        this.tipo_comprobante == "" ||
        this.serie_comprobante == "" ||
        this.numero_comprobante == "" ||
        this.total <= 0
      ) {
        return true;
      } else {
        return false;
      }
    },

    llenarArticulo: function() {
      //verificar que encontro el articulo
      if (this.arrayArticulos.length > 0) {
        this.articulo_id = this.arrayArticulos[0].id;
        this.nombreArticulo = this.arrayArticulos[0].nombre;
        return this.arrayArticulos[0].nombre;
      } else {
        return "Nombre del Artículo";
      }
    }
  },

  mounted() {
    //realizar las consultas al cargar el componente
    this.consultarVentas();
  }
};
</script>


