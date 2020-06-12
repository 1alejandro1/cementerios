<?php
	require "Conexion.php";

	class Grafico{


		public function __construct(){
		}

		public function ComprasMesSucursal($idsucursal){
			global $conexion;
			$sql = "SELECT
			monthname(i.Fecha) as mes, sum(i.total) as totalmes
			from ingreso i
			where i.estado='A' and i.idsucursal='$idsucursal'
			group by monthname(i.Fecha) order by month(i.Fecha) desc
			limit 12 ";
			$query = $conexion->query($sql);
			return $query;
		}

		public function VentasMesSucursal($idsucursal){
			global $conexion;
			$sql = "SELECT
			monthname(v.fecha) as mes, sum(v.total) as totalmes
			from venta v
			inner join detalle_pedido p on v.idventa=p.idventa
			where v.estado='A' and v.idsucursal=$idsucursal
			order by month(v.fecha) desc
			limit 12";
			$query = $conexion->query($sql);
			return $query;
		}

		public function VentasDiasSucursal($idsucursal){
			global $conexion;
			$sql = "SELECT
			v.fecha as dia, sum(v.total) as totaldia
			from venta v
			inner join detalle_pedido p on v.idventa=p.idventa
			where v.estado='A' and v.idsucursal=$idsucursal
			group by v.fecha
			order by day(v.fecha) desc
			limit 15";
			$query = $conexion->query($sql);
			return $query;
		}
		public function ProductosVendidosAno($idsucursal){
			global $conexion;
			$sql = "SELECT a.nombre as articulo,sum(dp.cantidad) as cantidad
			from articulo a inner join detalle_ingreso di
			on a.idarticulo=di.idarticulo
			inner join detalle_pedido dp on dp.iddetalle_ingreso=di.iddetalle_ingreso

			inner join venta v on dp.idventa=v.idventa
			where v.estado='A' and year(v.fecha)=year(curdate())
			 and v.idSucursal=$idsucursal
             AND dp.idventa = v.idventa
			group by a.nombre
			order by sum(dp.cantidad) desc
			limit 10";
			$query = $conexion->query($sql);
			return $query;
		}

		public function Totales($idsucursal){
			global $conexion;
			$sql = "SELECT (select simbolo_moneda from global order by idglobal desc limit 1 ) as moneda,(select ifnull(sum(total),0) from ingreso
			where fecha=curdate() and estado='A' and idsucursal=$idsucursal) as totalingreso,
			(select ifnull(sum(v.total),0) from venta v inner join detalle_pedido p
			on v.idventa = p.idventa
			where v.fecha=curdate()  and v.estado='A'
			) as totalcontado,
			(select ifnull(sum(c.total_pago),0) from credito c
			inner join venta v on c.idventa=v.idventa
			inner join detalle_pedido p on v.idventa=p.idventa
			where c.fecha_pago= curdate() and v.estado='A'
			and p.idventa = v.idventa) as totalcredito";
			$query = $conexion->query($sql);
			return $query;
		}

		public function ComprasMes(){
			global $conexion;
			$sql = "SELECT
			monthname(i.Fecha) as mes, sum(i.total) as totalmes
			from ingreso i
			where i.estado='A'
			group by monthname(i.Fecha) order by month(i.Fecha) desc
			limit 12 ";
			$query = $conexion->query($sql);
			return $query;
		}

		public function VentasMes(){
			global $conexion;
			$sql = "SELECT
			monthname(v.fecha) as mes, sum(v.total) as totalmes
			from venta v
			inner join detalle_pedido p on v.idventa=p.idventa
			where v.estado='A'
			group by monthname(v.fecha)
			order by month(v.fecha) desc
			limit 12";
			$query = $conexion->query($sql);
			return $query;
		}

		public function VentasDias(){
			global $conexion;
			$sql = "SELECT
			v.fecha as dia, sum(v.total) as totaldia
			from venta v
			inner join detalle_pedido p on v.idventa=p.idventa
			where v.estado='A'
			group by v.fecha
			order by day(v.Fecha) desc
			limit 15";
			$query = $conexion->query($sql);
			return $query;
		}
		public function ProductosVendidosAnoTotal(){
			global $conexion;
			$sql = "SELECT a.nombre as articulo,sum(dp.cantidad) as cantidad
			from articulo a inner join detalle_ingreso di
			on a.idarticulo=di.idarticulo
			inner join detalle_pedido dp on dp.iddetalle_ingreso=di.iddetalle_ingreso

			inner join venta v on dp.idventa=v.idventa
			where v.estado='A' and year(v.fecha)=year(curdate())
			group by a.nombre
			order by sum(dp.cantidad) desc
			limit 10";
			$query = $conexion->query($sql);
			return $query;
		}

		public function TotalesTotal(){
			global $conexion;
			$sql = "SELECT (select simbolo_moneda from global order by idglobal desc limit 1 ) as moneda,(select ifnull(sum(total),0) from ingreso
			where fecha=curdate() and estado='A') as totalingreso,
			(select ifnull(sum(v.total),0) from venta v inner join detalle_pedido p
			on v.idventa=p.idventa
			where v.fecha=curdate() and  v.estado='A') as totalcontado,
			(select ifnull(sum(c.total_pago),0) from credito c
			inner join venta v on c.idventa=v.idventa

			where c.fecha_pago= curdate() and v.estado='A') as totalcredito";
			$query = $conexion->query($sql);
			return $query;
		}


	}
