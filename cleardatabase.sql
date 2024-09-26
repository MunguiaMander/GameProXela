TRUNCATE TABLE
    rcempleado.empleado,
    rcempleado.sucursal,
    rcempleado.rol,
    rccliente.categoriatarjeta,
    rccliente.cliente,
    rccliente.tarjetapuntos,
    rcpersonal.producto,
    rcpersonal.bodega,
    rcpersonal.estanteria,
    rcpersonal.venta,
    rcpersonal.detalleventa
RESTART IDENTITY CASCADE;
