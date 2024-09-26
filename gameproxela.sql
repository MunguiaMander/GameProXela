-- Creacion de base de datos
CREATE DATABASE gameproxela;

\c gameproxela

-- Creacion de esquemas
CREATE SCHEMA rcpersonal;
CREATE SCHEMA rcempleado;
CREATE SCHEMA rccliente;

-- Creacion del su
CREATE USER gameproxela WITH PASSWORD 'gameproxela';
GRANT ALL PRIVILEGES ON DATABASE gameproxela TO gameproxela;
ALTER USER gameproxela WITH SUPERUSER;


-- Creacion de tablas
CREATE TABLE rcempleado.sucursal(
    codigo_sucursal SERIAL,
    nombre varchar(50) NOT NULL,
    PRIMARY KEY (codigo_sucursal)
);

CREATE TABLE rcempleado.rol(
    codigo_rol SERIAL,
    nombre varchar(50) NOT NULL,
    PRIMARY KEY (codigo_rol)
);

CREATE TABLE rcempleado.empleado(
    codigo_empleado SERIAL,
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL,
    username varchar(50) NOT NULL,
    password varchar NOT NULL,
    no_caja int NOT NULL,
    codigo_sucursal int NOT NULL,
    codigo_rol INT NOT NULL,
    PRIMARY KEY (codigo_empleado),
    FOREIGN KEY (codigo_sucursal) REFERENCES rcempleado.sucursal(codigo_sucursal),
    FOREIGN KEY (codigo_rol) REFERENCES rcempleado.rol(codigo_rol)
);

CREATE TABLE rccliente.categoriatarjeta(
    codigo_categoria SERIAL,
    nombre varchar(50) NOT NULL,
    PRIMARY KEY (codigo_categoria)
);

CREATE TABLE rccliente.cliente(
    nit_cliente VARCHAR(50) NOT NULL,
    nombre varchar(250) NOT NULL,
    direccion varchar(50) NOT NULL,
    no_puntos int NOT NULL,
    PRIMARY KEY (nit_cliente)
);

CREATE TABLE rccliente.tarjetapuntos(
    nit_cliente VARCHAR(50) NOT NULL,
    codigo_categoria int NOT NULL,
    total_gastado float NOT NULL,
    PRIMARY KEY (nit_cliente),
    FOREIGN KEY (nit_cliente) REFERENCES rccliente.cliente(nit_cliente),
    FOREIGN KEY (codigo_categoria) REFERENCES rccliente.categoriatarjeta(codigo_categoria)
);

CREATE TABLE rcpersonal.producto(
    codigo_producto SERIAL,
    nombre varchar(50) NOT NULL,
    precio float NOT NULL,
    descripcion varchar(150) NOT NULL,
    marca varchar(50) NOT NULL,
    PRIMARY KEY (codigo_producto)
);

CREATE TABLE rcpersonal.bodega(
    sucursal int NOT NULL,
    producto int NOT NULL,
    cantidad int NOT NULL,
    PRIMARY KEY (sucursal, producto),
    FOREIGN KEY (sucursal) REFERENCES rcempleado.sucursal(codigo_sucursal),
    FOREIGN KEY (producto) REFERENCES rcpersonal.producto(codigo_producto)
);

CREATE TABLE rcpersonal.estanteria(
    sucursal int NOT NULL,
    producto int NOT NULL,
    cantidad int NOT NULL,
    no_pasillo int NOT NULL,
    PRIMARY KEY (sucursal, producto),
    FOREIGN KEY (sucursal) REFERENCES rcempleado.sucursal(codigo_sucursal),
    FOREIGN KEY (producto) REFERENCES rcpersonal.producto(codigo_producto)
);

CREATE TABLE rcpersonal.venta(
    codigo_venta SERIAL,
    fecha date NOT NULL,
    subtotal float NOT NULL,
    descuento float NOT NULL,
    total float NOT NULL,
    nit_cliente VARCHAR(50) NOT NULL,
    codigo_empleado int NOT NULL,
    PRIMARY KEY (codigo_venta),
    FOREIGN KEY (nit_cliente) REFERENCES rccliente.cliente(nit_cliente),
    FOREIGN KEY (codigo_empleado) REFERENCES rcempleado.empleado(codigo_empleado)
);

CREATE TABLE rcpersonal.detalleventa(
    codigo_detalle_venta SERIAL,
    codigo_venta int NOT NULL,
    producto int NOT NULL,
    cantidad int NOT NULL,
    PRIMARY KEY (codigo_detalle_venta),
    FOREIGN KEY (codigo_venta) REFERENCES rcpersonal.venta(codigo_venta),
    FOREIGN KEY (producto) REFERENCES rcpersonal.producto(codigo_producto)
);

--Insert de Clientes
INSERT INTO rccliente.cliente (nit_cliente, nombre, direccion, no_puntos) VALUES
('1', 'Marco Munguia', 'Calle 123, San Marcos', 0),
('2', 'Juan Diego', 'Avenida 45, Xela', 100),
('3', 'Jose Munguia', 'Boulevard 67, Trigales', 300),
('4', 'Diego Calderon', 'Calle Barrabasada, Xecaracoj', 500),
('5', 'Diego Calderon', 'Calle Parque, San Marcos', 500),
('6', 'Diego Calderon', 'Calle F5, 888', 500),
('7', 'Diego Calderon', 'Calle WASD, Xela', 500),
('8', 'Pancho Pistolas', 'Avenida Siempre Viva', 1000);


-- INSERT DE PRODUCTOS AL SISTEMA
INSERT INTO rcpersonal.producto (nombre, precio, descripcion, marca) VALUES
('PlayStation 5', 499.99, 'Consola de ultima generacion', 'Sony'),
('Xbox Series X', 499.99, 'Consola potente de Microsoft', 'Microsoft'),
('Nintendo Switch', 299.99, 'Consola hibrida portatil', 'Nintendo'),
('The Legend of Zelda: Breath of the Wild', 59.99, 'Juego de aventuras para Switch', 'Nintendo'),
('God of War: Ragnarok', 69.99, 'Juego de accion para PS5', 'Sony'),
('Halo Infinite', 59.99, 'Shooter en primera persona para Xbox', 'Microsoft'),
('iPhone 13 Pro', 999.99, 'Smartphone de alta gama', 'Apple'),
('MacBook Air M1', 999.99, 'Portatil ultraligero con chip M1', 'Apple'),
('Galaxy S21', 799.99, 'Smartphone de alta gama', 'Samsung'),
('iPad Pro 12.9"', 1099.99, 'Tableta profesional de 12.9 pulgadas', 'Apple'),
('AirPods Pro', 249.99, 'Auriculares inalambricos con cancelacion de ruido', 'Apple'),
('Google Pixel 6', 699.99, 'Smartphone con Android puro', 'Google'),
('Samsung Galaxy Watch 4', 249.99, 'Reloj inteligente con funciones de salud', 'Samsung'),
('Sony WH-1000XM4', 349.99, 'Auriculares inalambricos con cancelacion de ruido', 'Sony'),
('Razer BlackWidow Elite', 169.99, 'Teclado mecanico para gaming', 'Razer'),
('Asus ROG Strix G15', 1199.99, 'Portatil para gaming con NVIDIA RTX', 'Asus'),
('MSI GP66 Leopard', 1499.99, 'Portatil gaming de alto rendimiento', 'MSI'),
('Lenovo Legion 5', 1299.99, 'Portatil gaming con AMD Ryzen', 'Lenovo'),
('Dell XPS 13', 1099.99, 'Portatil ultraligero con pantalla InfinityEdge', 'Dell'),
('HP Spectre x360', 1399.99, 'Convertible premium con pantalla tactil', 'HP'),
('Alienware Aurora R12', 1799.99, 'PC de sobremesa para gaming', 'Alienware'),
('Nintendo Switch Pro Controller', 69.99, 'Mando Pro para Nintendo Switch', 'Nintendo'),
('Logitech MX Master 3', 99.99, 'Raton inalambrico de alta precision', 'Logitech'),
('Corsair K95 RGB Platinum', 199.99, 'Teclado mecanico con retroiluminacion RGB', 'Corsair'),
('Logitech G502 HERO', 79.99, 'Raton gaming con sensor HERO', 'Logitech'),
('Razer Naga Trinity', 99.99, 'Raton gaming modular con multiples botones', 'Razer'),
('Canon EOS R5', 3899.99, 'Camara sin espejo con grabacion 8K', 'Canon'),
('Sony Alpha 7C', 1799.99, 'Camara full-frame compacta', 'Sony'),
('GoPro HERO10 Black', 499.99, 'Camara de accion con grabacion 5.3K', 'GoPro'),
('DJI Mavic Air 2', 799.99, 'Dron plegable con camara 4K', 'DJI'),
('Bose SoundLink Revolve', 199.99, 'Altavoz Bluetooth con sonido envolvente', 'Bose'),
('Echo Dot (4th Gen)', 49.99, 'Altavoz inteligente con Alexa', 'Amazon'),
('Kindle Paperwhite', 129.99, 'E-reader con pantalla de alta resolucion', 'Amazon'),
('Samsung Odyssey G9', 1499.99, 'Monitor curvo ultra ancho para gaming', 'Samsung'),
('LG CX OLED 65"', 1999.99, 'Televisor OLED 4K de 65 pulgadas', 'LG'),
('Apple Watch Series 7', 399.99, 'Reloj inteligente con pantalla mas grande', 'Apple'),
('Fitbit Charge 5', 179.99, 'Monitor de actividad fisica avanzado', 'Fitbit'),
('Razer Kraken X', 49.99, 'Auriculares gaming ligeros con sonido envolvente', 'Razer'),
('HyperX Cloud II', 99.99, 'Auriculares gaming con sonido envolvente', 'HyperX'),
('SteelSeries Arctis 7', 149.99, 'Auriculares inalambricos para gaming', 'SteelSeries'),
('Elgato Stream Deck', 149.99, 'Controlador para streaming con teclas personalizables', 'Elgato'),
('Acer Predator Helios 300', 1299.99, 'Portatil gaming con NVIDIA RTX', 'Acer'),
('Asus TUF Gaming A15', 1099.99, 'Portatil gaming con AMD Ryzen', 'Asus'),
('Razer Blade 15', 1899.99, 'Portatil gaming premium con pantalla de 144Hz', 'Razer'),
('Samsung Galaxy Tab S7+', 849.99, 'Tableta Android de alta gama con S-Pen', 'Samsung'),
('Microsoft Surface Laptop 4', 1299.99, 'Portatil ligero con pantalla tactil', 'Microsoft'),
('Google Nest Hub (2nd Gen)', 99.99, 'Pantalla inteligente con Google Assistant', 'Google'),
('Sony PS5 DualSense Controller', 69.99, 'Mando inalambrico para PlayStation 5', 'Sony'),
('Xbox Elite Wireless Controller Series 2', 179.99, 'Mando inalambrico premium para Xbox', 'Microsoft'),
('Sony PlayStation VR', 349.99, 'Sistema de realidad virtual para PS4/PS5', 'Sony'),
('Oculus Quest 2', 399.99, 'Visor de realidad virtual independiente', 'Meta'),
('Valve Index', 999.99, 'Kit completo de realidad virtual de alta gama', 'Valve'),
('Apple AirTag', 29.99, 'Dispositivo de rastreo inteligente', 'Apple'),
('Google Chromecast', 49.99, 'Dispositivo de streaming multimedia', 'Google'),
('Roku Streaming Stick+', 59.99, 'Dispositivo de streaming en 4K', 'Roku'),
('Apple TV 4K', 179.99, 'Dispositivo de streaming en 4K con Siri', 'Apple'),
('TP-Link Archer AX6000', 299.99, 'Router Wi-Fi 6 de alto rendimiento', 'TP-Link'),
('Netgear Nighthawk AX12', 499.99, 'Router Wi-Fi 6 de largo alcance', 'Netgear'),
('Eero Pro 6', 199.99, 'Sistema Wi-Fi Mesh con soporte para Alexa', 'Amazon'),
('Samsung 980 Pro SSD', 199.99, 'SSD NVMe de alto rendimiento', 'Samsung'),
('WD Black SN850 SSD', 179.99, 'SSD NVMe con PCIe 4.0 para gaming', 'Western Digital'),
('Seagate Expansion 5TB', 129.99, 'Disco duro externo de 5TB', 'Seagate'),
('LaCie Rugged 4TB', 159.99, 'Disco duro externo resistente para profesionales', 'LaCie'),
('Synology DS920+', 549.99, 'Servidor NAS de 4 bahias para almacenamiento', 'Synology'),
('QNAP TS-451D2', 499.99, 'Servidor NAS de 4 bahias con HDMI', 'QNAP'),
('Logitech BRIO', 199.99, 'Camara web 4K para videoconferencias', 'Logitech'),
('Razer Kiyo', 99.99, 'Camara web con anillo de luz integrado', 'Razer'),
('Canon PIXMA G6020', 199.99, 'Impresora multifuncion con tanque de tinta', 'Canon'),
('HP OfficeJet Pro 9025', 299.99, 'Impresora multifuncion para oficinas', 'HP'),
('Epson EcoTank ET-2720', 229.99, 'Impresora con sistema de tanque de tinta', 'Epson'),
('Brother HL-L2390DW', 169.99, 'Impresora laser monocromo con Wi-Fi', 'Brother'),
('Corsair Vengeance RGB Pro 32GB', 179.99, 'Memoria RAM DDR4 para gaming', 'Corsair'),
('G.Skill Trident Z RGB 16GB', 99.99, 'Memoria RAM DDR4 con iluminacion RGB', 'G.Skill'),
('Kingston HyperX Fury 16GB', 79.99, 'Memoria RAM DDR4 para gaming', 'Kingston'),
('AMD Ryzen 9 5900X', 549.99, 'Procesador de 12 nucleos para gaming', 'AMD'),
('Intel Core i9-11900K', 529.99, 'Procesador de 8 nucleos de alta gama', 'Intel'),
('AMD Radeon RX 6900 XT', 999.99, 'Tarjeta grafica de alto rendimiento', 'AMD'),
('NVIDIA GeForce RTX 3080', 1199.99, 'Tarjeta grafica de alto rendimiento para gaming', 'NVIDIA'),
('Cooler Master Hyper 212', 49.99, 'Disipador de aire para CPU con alto rendimiento', 'Cooler Master'),
('Noctua NH-D15', 89.99, 'Disipador de aire premium para CPU', 'Noctua'),
('Be Quiet! Dark Rock Pro 4', 79.99, 'Disipador de aire silencioso para CPU', 'Be Quiet!'),
('Corsair iCUE H100i RGB Pro XT', 149.99, 'Sistema de refrigeracion liquida para CPU', 'Corsair'),
('NZXT Kraken Z63', 249.99, 'Refrigeracion liquida con pantalla LCD', 'NZXT'),
('Thermaltake Toughpower GF1 750W', 119.99, 'Fuente de alimentacion 80 PLUS Gold', 'Thermaltake'),
('EVGA SuperNOVA 850W', 149.99, 'Fuente de alimentacion 80 PLUS Gold modular', 'EVGA'),
('Corsair RM850x', 129.99, 'Fuente de alimentacion 80 PLUS Gold', 'Corsair'),
('HyperX QuadCast', 139.99, 'Microfono para streaming y podcasting', 'HyperX'),
('Blue Yeti', 129.99, 'Microfono USB para grabacion y streaming', 'Blue'),
('Shure SM7B', 399.99, 'Microfono dinamico profesional', 'Shure'),
('Rode NT1-A', 229.99, 'Microfono de condensador para estudio', 'Rode'),
('Focusrite Scarlett 2i2', 169.99, 'Interfaz de audio para grabacion en estudio', 'Focusrite'),
('PreSonus AudioBox USB 96', 99.99, 'Interfaz de audio portatil', 'PreSonus'),
('Elgato Game Capture HD60 S', 179.99, 'Tarjeta de captura para streaming', 'Elgato'),
('AverMedia Live Gamer Portable 2 Plus', 149.99, 'Tarjeta de captura para streaming en 4K', 'AverMedia'),
('Elgato Key Light', 199.99, 'Luz LED para creadores de contenido', 'Elgato'),
('Neewer Ring Light Kit', 89.99, 'Kit de luz anular con soporte para camara', 'Neewer'),
('Logitech Z906', 399.99, 'Sistema de altavoces 5.1 con sonido envolvente', 'Logitech'),
('Anker PowerCore 20100', 49.99, 'Bateria portatil de alta capacidad', 'Anker'),
('Belkin BoostCharge 15W', 29.99, 'Cargador inalambrico rapido', 'Belkin'),
('SanDisk Extreme Pro 128GB', 39.99, 'Tarjeta microSD con alta velocidad de lectura y escritura', 'SanDisk'),
('WD My Passport 4TB', 99.99, 'Disco duro portatil de 4TB', 'Western Digital'),
('Kingston A2000 1TB SSD', 109.99, 'SSD NVMe con gran rendimiento', 'Kingston'),
('Acer Predator X34', 899.99, 'Monitor curvo ultra ancho para gaming', 'Acer'),
('Asus VG248QG', 279.99, 'Monitor de 24 pulgadas con 165Hz', 'Asus'),
('BenQ ZOWIE XL2411P', 229.99, 'Monitor gaming con alta tasa de refresco', 'BenQ'),
('Philips Hue Lightstrip Plus', 79.99, 'Tira de luces inteligentes controlada por app', 'Philips'),
('Ring Video Doorbell 3', 199.99, 'Timbre con camara de video y Wi-Fi', 'Ring'),
('Nest Thermostat E', 169.99, 'Termostato inteligente con control remoto', 'Google'),
('Ecobee SmartThermostat', 249.99, 'Termostato inteligente con Alexa integrada', 'Ecobee'),
('Netatmo Weather Station', 179.99, 'Estacion meteorologica inteligente', 'Netatmo'),
('Google Nest Cam IQ', 299.99, 'Camara de seguridad inteligente con reconocimiento facial', 'Google'),
('Arlo Pro 3', 499.99, 'Sistema de camaras de seguridad con resolucion 2K', 'Arlo'),
('TP-Link Kasa Smart Plug', 19.99, 'Enchufe inteligente controlado por app', 'TP-Link'),
('Amazon Fire TV Stick 4K', 49.99, 'Dispositivo de streaming en 4K con Alexa', 'Amazon'),
('Samsung Galaxy Buds Pro', 199.99, 'Auriculares inalambricos con cancelacion de ruido', 'Samsung'),
('Sony WF-1000XM3', 229.99, 'Auriculares inalambricos con cancelacion de ruido', 'Sony'),
('Bose QuietComfort Earbuds', 279.99, 'Auriculares inalambricos con sonido envolvente', 'Bose'),
('JBL Charge 4', 149.99, 'Altavoz Bluetooth portatil resistente al agua', 'JBL'),
('Ultimate Ears Boom 3', 129.99, 'Altavoz Bluetooth con sonido 360', 'Ultimate Ears'),
('Marshall Kilburn II', 299.99, 'Altavoz Bluetooth portatil con diseno retro', 'Marshall'),
('Sennheiser HD 560S', 199.99, 'Auriculares de alta fidelidad para audiofilos', 'Sennheiser'),
('Audio-Technica ATH-M50X', 149.99, 'Auriculares de estudio con gran precision', 'Audio-Technica'),
('Razer Seiren X', 99.99, 'Microfono de condensador para streaming', 'Razer'),
('Acer Swift 3', 699.99, 'Portatil ultraligero con procesador AMD Ryzen', 'Acer'),
('Lenovo Yoga 7i', 899.99, 'Portatil convertible con pantalla tactil', 'Lenovo'),
('Dell G5 Gaming Desktop', 899.99, 'PC de escritorio para gaming con Intel Core i7', 'Dell'),
('Asus ROG Strix Scar 15', 1799.99, 'Portatil gaming de alta gama con RTX 3070', 'Asus');

-- Insert de las sucursales
INSERT INTO rcempleado.sucursal (nombre)
VALUES ('Sucursal Parque'), ('Sucursal Centro1'), ('Sucursal Centro2');

-- Insert los roles para poder registrar empleados
-- Al ser un SERIAL el codigo de rol, 1 = Admin; 2 = Caja, 3 = Bodega y 4 = Inventario
INSERT INTO rcempleado.rol (nombre)
VALUES ('Administrador'), ('Empleado de caja'), ('Empleado de bodega'), ('Empleado de Inventario');

--Insert de las tarjetas
-- Al ser un SERIAL el codigo de rol, 1 = Comun; 2 = Oro, 3 = Platino y 4 = Diamante
INSERT INTO rccliente.categoriatarjeta (nombre) VALUES
('Comun'),
('Oro'),
('Platino'),
('Diamante');

--INSERTS DE STOCK A TIENDAS 
INSERT INTO rcpersonal.bodega (sucursal, producto, cantidad) VALUES
(1, 1, 50),   -- PlayStation 5
(1, 2, 40),   -- Xbox Series X
(1, 3, 60),   -- Nintendo Switch
(1, 4, 100),  -- The Legend of Zelda: Breath of the Wild
(1, 5, 80),   -- God of War: Ragnarok
(1, 6, 50),   -- Halo Infinite
(1, 7, 30),   -- iPhone 13 Pro
(1, 8, 20),   -- MacBook Air M1
(1, 9, 50),   -- Galaxy S21
(1, 10, 25),  -- iPad Pro 12.9"
(1, 11, 80),  -- AirPods Pro
(1, 12, 60),  -- Google Pixel 6
(1, 13, 40),  -- Samsung Galaxy Watch 4
(1, 14, 30),  -- Sony WH-1000XM4
(1, 15, 25),  -- Razer BlackWidow Elite
(1, 16, 40),  -- Asus ROG Strix G15
(1, 17, 50),  -- MSI GP66 Leopard
(1, 18, 60),  -- Lenovo Legion 5
(1, 19, 70),  -- Dell XPS 13
(1, 20, 30),  -- HP Spectre x360
(1, 21, 25),  -- Alienware Aurora R12
(1, 22, 40),  -- Nintendo Switch Pro Controller
(1, 23, 50),  -- Logitech MX Master 3
(1, 24, 35),  -- Corsair K95 RGB Platinum
(1, 25, 45),  -- Logitech G502 HERO
(1, 26, 55),  -- Razer Naga Trinity
(1, 27, 25),  -- Canon EOS R5
(1, 28, 60),  -- Sony Alpha 7C
(1, 29, 50),  -- GoPro HERO10 Black
(1, 30, 45),  -- DJI Mavic Air 2
(1, 31, 55),  -- Bose SoundLink Revolve
(1, 32, 65),  -- Echo Dot (4th Gen)
(1, 33, 70),  -- Kindle Paperwhite
(1, 34, 30),  -- Samsung Odyssey G9
(1, 35, 40),  -- LG CX OLED 65"
(1, 36, 25),  -- Apple Watch Series 7
(1, 37, 60),  -- Fitbit Charge 5
(1, 38, 75),  -- Razer Kraken X
(1, 39, 80),  -- HyperX Cloud II
(1, 40, 90),  -- SteelSeries Arctis 7
(1, 41, 50),  -- Elgato Stream Deck
(1, 42, 25),  -- Acer Predator Helios 300
(1, 43, 35),  -- Asus TUF Gaming A15
(1, 44, 40),  -- Razer Blade 15
(1, 45, 50),  -- Samsung Galaxy Tab S7+
(1, 46, 35),  -- Microsoft Surface Laptop 4
(1, 47, 45),  -- Google Nest Hub (2nd Gen)
(1, 48, 20),  -- Sony PS5 DualSense Controller
(1, 49, 55),  -- Xbox Elite Wireless Controller Series 2
(1, 50, 65),  -- Sony PlayStation VR
(1, 51, 75),  -- Oculus Quest 2
(1, 52, 80),  -- Valve Index
(1, 53, 90),  -- Apple AirTag
(1, 54, 60),  -- Google Chromecast
(1, 55, 45),  -- Roku Streaming Stick+
(1, 56, 55),  -- Apple TV 4K
(1, 57, 65),  -- TP-Link Archer AX6000
(1, 58, 50),  -- Netgear Nighthawk AX12
(1, 59, 75),  -- Eero Pro 6
(1, 60, 85),  -- Samsung 980 Pro SSD
(1, 61, 90),  -- WD Black SN850 SSD
(1, 62, 100), -- Seagate Expansion 5TB
(1, 63, 50),  -- LaCie Rugged 4TB
(1, 64, 60),  -- Synology DS920+
(1, 65, 45),  -- QNAP TS-451D2
(1, 66, 25),  -- Logitech BRIO
(1, 67, 35),  -- Razer Kiyo
(1, 68, 40),  -- Canon PIXMA G6020
(1, 69, 60),  -- HP OfficeJet Pro 9025
(1, 70, 50),  -- Epson EcoTank ET-2720
(1, 71, 75),  -- Brother HL-L2390DW
(1, 72, 80),  -- Corsair Vengeance RGB Pro 32GB
(1, 73, 65),  -- G.Skill Trident Z RGB 16GB
(1, 74, 40),  -- Kingston HyperX Fury 16GB
(1, 75, 45),  -- AMD Ryzen 9 5900X
(1, 76, 55),  -- Intel Core i9-11900K
(1, 77, 65),  -- AMD Radeon RX 6900 XT
(1, 78, 75),  -- NVIDIA GeForce RTX 3080
(1, 79, 85),  -- Cooler Master Hyper 212
(1, 80, 40),  -- Noctua NH-D15
(1, 81, 55),  -- Be Quiet! Dark Rock Pro 4
(1, 82, 65),  -- Corsair iCUE H100i RGB Pro XT
(1, 83, 75),  -- NZXT Kraken Z63
(1, 84, 50),  -- Thermaltake Toughpower GF1 750W
(1, 85, 55),  -- EVGA SuperNOVA 850W
(1, 86, 45),  -- Corsair RM850x
(1, 87, 35),  -- HyperX QuadCast
(1, 88, 40),  -- Blue Yeti
(1, 89, 60),  -- Shure SM7B
(1, 90, 70),  -- Rode NT1-A
(1, 91, 75),  -- Focusrite Scarlett 2i2
(1, 92, 80),  -- PreSonus AudioBox USB 96
(1, 93, 55),  -- Elgato Game Capture HD60 S
(1, 94, 65),  -- AverMedia Live Gamer Portable 2 Plus
(1, 95, 45),  -- Elgato Key Light
(1, 96, 75),  -- Neewer Ring Light Kit
(1, 97, 90),  -- Logitech Z906
(1, 98, 100), -- Anker PowerCore 20100
(1, 99, 50),  -- Belkin BoostCharge 15W
(1, 100, 40); -- SanDisk Extreme Pro 128GB

INSERT INTO rcpersonal.bodega (sucursal, producto, cantidad) VALUES
(2, 1, 25),   -- PlayStation 5
(2, 3, 30),   -- Nintendo Switch
(2, 4, 20),   -- The Legend of Zelda: Breath of the Wild
(2, 6, 25),   -- Halo Infinite
(2, 8, 15),   -- MacBook Air M1
(2, 9, 20),   -- Galaxy S21
(2, 10, 10),  -- iPad Pro 12.9"
(2, 11, 35),  -- AirPods Pro
(2, 14, 40),  -- Sony WH-1000XM4
(2, 15, 20),  -- Razer BlackWidow Elite
(2, 18, 25),  -- Lenovo Legion 5
(2, 20, 15),  -- HP Spectre x360
(2, 21, 10),  -- Alienware Aurora R12
(2, 23, 25),  -- Logitech MX Master 3
(2, 25, 30),  -- Logitech G502 HERO
(2, 28, 35),  -- Sony Alpha 7C
(2, 29, 30),  -- GoPro HERO10 Black
(2, 31, 20),  -- Bose SoundLink Revolve
(2, 32, 25),  -- Echo Dot (4th Gen)
(2, 33, 30),  -- Kindle Paperwhite
(2, 34, 15),  -- Samsung Odyssey G9
(2, 36, 25),  -- Apple Watch Series 7
(2, 39, 30),  -- HyperX Cloud II
(2, 40, 40),  -- SteelSeries Arctis 7
(2, 41, 10),  -- Elgato Stream Deck
(2, 43, 20),  -- Asus TUF Gaming A15
(2, 45, 25),  -- Samsung Galaxy Tab S7+
(2, 47, 15),  -- Google Nest Hub (2nd Gen)
(2, 48, 35),  -- Sony PS5 DualSense Controller
(2, 49, 45),  -- Xbox Elite Wireless Controller Series 2
(2, 50, 55),  -- Sony PlayStation VR
(2, 52, 40),  -- Valve Index
(2, 55, 20),  -- Roku Streaming Stick+
(2, 56, 30),  -- Apple TV 4K
(2, 57, 40),  -- TP-Link Archer AX6000
(2, 60, 35),  -- Samsung 980 Pro SSD
(2, 61, 25),  -- WD Black SN850 SSD
(2, 62, 20),  -- Seagate Expansion 5TB
(2, 63, 30),  -- LaCie Rugged 4TB
(2, 64, 35),  -- Synology DS920+
(2, 65, 25),  -- QNAP TS-451D2
(2, 67, 20),  -- Razer Kiyo
(2, 68, 25),  -- Canon PIXMA G6020
(2, 69, 30),  -- HP OfficeJet Pro 9025
(2, 70, 40),  -- Epson EcoTank ET-2720
(2, 72, 30),  -- Corsair Vengeance RGB Pro 32GB
(2, 73, 35),  -- G.Skill Trident Z RGB 16GB
(2, 75, 20),  -- AMD Ryzen 9 5900X
(2, 76, 25),  -- Intel Core i9-11900K
(2, 77, 40),  -- AMD Radeon RX 6900 XT
(2, 78, 50),  -- NVIDIA GeForce RTX 3080
(2, 79, 60),  -- Cooler Master Hyper 212
(2, 80, 25),  -- Noctua NH-D15
(2, 81, 15),  -- Be Quiet! Dark Rock Pro 4
(2, 83, 35),  -- NZXT Kraken Z63
(2, 85, 25),  -- EVGA SuperNOVA 850W
(2, 86, 35),  -- Corsair RM850x
(2, 88, 20),  -- Blue Yeti
(2, 89, 30),  -- Shure SM7B
(2, 90, 40),  -- Rode NT1-A
(2, 91, 45),  -- Focusrite Scarlett 2i2
(2, 92, 50),  -- PreSonus AudioBox USB 96
(2, 93, 25),  -- Elgato Game Capture HD60 S
(2, 94, 35),  -- AverMedia Live Gamer Portable 2 Plus
(2, 97, 60),  -- Logitech Z906
(2, 98, 20),  -- Anker PowerCore 20100
(2, 99, 15),  -- Belkin BoostCharge 15W
(2, 100, 30); -- SanDisk Extreme Pro 128GB

INSERT INTO rcpersonal.bodega (sucursal, producto, cantidad) VALUES
(3, 2, 30),   -- Xbox Series X
(3, 5, 20),   -- God of War: Ragnarok
(3, 7, 15),   -- iPhone 13 Pro
(3, 9, 25),   -- Galaxy S21
(3, 12, 35),  -- Google Pixel 6
(3, 13, 40),  -- Samsung Galaxy Watch 4
(3, 17, 20),  -- MSI GP66 Leopard
(3, 19, 15),  -- Dell XPS 13
(3, 22, 30),  -- Nintendo Switch Pro Controller
(3, 24, 40),  -- Corsair K95 RGB Platinum
(3, 26, 50),  -- Canon EOS R5
(3, 27, 60),  -- Sony Alpha 7C
(3, 30, 70),  -- DJI Mavic Air 2
(3, 32, 45),  -- Echo Dot (4th Gen)
(3, 33, 25),  -- Kindle Paperwhite
(3, 35, 30),  -- LG CX OLED 65"
(3, 36, 40),  -- Apple Watch Series 7
(3, 38, 50),  -- Razer Kraken X
(3, 41, 25),  -- Elgato Stream Deck
(3, 42, 20),  -- Acer Predator Helios 300
(3, 45, 30),  -- Samsung Galaxy Tab S7+
(3, 46, 35),  -- Microsoft Surface Laptop 4
(3, 47, 25),  -- Google Nest Hub (2nd Gen)
(3, 49, 50),  -- Xbox Elite Wireless Controller Series 2
(3, 51, 40),  -- Oculus Quest 2
(3, 54, 35),  -- Google Chromecast
(3, 58, 30),  -- Netgear Nighthawk AX12
(3, 59, 45),  -- Eero Pro 6
(3, 61, 25),  -- WD Black SN850 SSD
(3, 62, 20),  -- Seagate Expansion 5TB
(3, 63, 15),  -- LaCie Rugged 4TB
(3, 65, 35),  -- QNAP TS-451D2
(3, 66, 20),  -- Logitech BRIO
(3, 68, 40),  -- Canon PIXMA G6020
(3, 69, 35),  -- HP OfficeJet Pro 9025
(3, 71, 30),  -- Brother HL-L2390DW
(3, 72, 25),  -- Corsair Vengeance RGB Pro 32GB
(3, 74, 45),  -- Kingston HyperX Fury 16GB
(3, 75, 20),  -- AMD Ryzen 9 5900X
(3, 77, 30),  -- AMD Radeon RX 6900 XT
(3, 79, 25),  -- Cooler Master Hyper 212
(3, 81, 40),  -- Be Quiet! Dark Rock Pro 4
(3, 83, 35),  -- NZXT Kraken Z63
(3, 84, 45),  -- Thermaltake Toughpower GF1 750W
(3, 85, 50),  -- EVGA SuperNOVA 850W
(3, 87, 60),  -- HyperX QuadCast
(3, 88, 40),  -- Blue Yeti
(3, 90, 30),  -- Rode NT1-A
(3, 92, 45),  -- PreSonus AudioBox USB 96
(3, 93, 20),  -- Elgato Game Capture HD60 S
(3, 95, 55),  -- Elgato Key Light
(3, 97, 50),  -- Logitech Z906
(3, 98, 60),  -- Anker PowerCore 20100
(3, 99, 30),  -- Belkin BoostCharge 15W
(3, 100, 25), -- SanDisk Extreme Pro 128GB
(3, 16, 40),  -- Asus ROG Strix G15
(3, 28, 50),  -- Sony Alpha 7C
(3, 44, 45),  -- Razer Blade 15
(3, 50, 35),  -- Sony PlayStation VR
(3, 55, 25),  -- Roku Streaming Stick+
(3, 64, 35),  -- Synology DS920+
(3, 76, 40),  -- Intel Core i9-11900K
(3, 86, 30),  -- Corsair RM850x
(3, 18, 20),  -- Lenovo Legion 5
(3, 73, 35),  -- G.Skill Trident Z RGB 16GB
(3, 20, 25),  -- HP Spectre x360
(3, 34, 30),  -- Samsung Odyssey G9
(3, 70, 20);  -- Epson EcoTank ET-2720



-- TERMINAN LOS INSERTS


--Trigger para cuando el bodeguero quiere agregar el mismo producto a su sucursal
CREATE OR REPLACE FUNCTION actualizar_producto_bodega()
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS(SELECT 1 FROM rcpersonal.bodega
            WHERE sucursal = NEW.sucursal
            AND producto = NEW.producto) THEN
        UPDATE rcpersonal.bodega
        SET cantidad = cantidad + NEW.cantidad
        WHERE sucursal = NEW.sucursal
        AND producto = NEW.producto;
        RETURN NULL;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_producto_bodega
BEFORE INSERT ON rcpersonal.bodega
FOR EACH ROW EXECUTE FUNCTION actualizar_producto_bodega();

--Trigger para actualizar inventario luego de una venta
CREATE OR REPLACE FUNCTION actualizar_inventario() RETURNS TRIGGER AS $$
DECLARE
    sucursal_venta INT;
    cantidad_estanteria INT;
BEGIN
    SELECT codigo_sucursal INTO sucursal_venta
    FROM rcpersonal.venta
    JOIN rcempleado.empleado ON rcpersonal.venta.codigo_empleado = rcempleado.empleado.codigo_empleado
    WHERE rcpersonal.venta.codigo_venta = NEW.codigo_venta;

    SELECT cantidad INTO cantidad_estanteria
    FROM rcpersonal.estanteria
    WHERE sucursal = sucursal_venta
    AND producto = NEW.producto
    FOR UPDATE;

    IF cantidad_estanteria >= NEW.cantidad THEN
        UPDATE rcpersonal.estanteria
        SET cantidad = cantidad - NEW.cantidad
        WHERE sucursal = sucursal_venta
        AND producto = NEW.producto;
    ELSE
        RAISE EXCEPTION 'No hay suficiente cantidad en estantería para completar la venta. Disponible: %, Solicitado: %', cantidad_estanteria, NEW.cantidad;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_inventario
AFTER INSERT ON rcpersonal.detalleventa
FOR EACH ROW
EXECUTE FUNCTION actualizar_inventario();


-- Trigger para actualizar estanteria por el empleado de inventario
CREATE OR REPLACE FUNCTION actualizar_inventario_estanteria()
RETURNS TRIGGER AS $$
DECLARE
    cantidad_bodega INT;
BEGIN
    SELECT cantidad INTO cantidad_bodega
    FROM rcpersonal.bodega
    WHERE sucursal = NEW.sucursal
    AND producto = NEW.producto
    FOR UPDATE;

    IF NOT FOUND OR cantidad_bodega < NEW.cantidad THEN
        RAISE EXCEPTION 'No hay suficiente cantidad en bodega para trasladar a la estantería. Disponible: %, Solicitado: %', cantidad_bodega, NEW.cantidad;
    END IF;

    UPDATE rcpersonal.bodega
    SET cantidad = cantidad - NEW.cantidad
    WHERE sucursal = NEW.sucursal
    AND producto = NEW.producto;

    IF (SELECT cantidad FROM rcpersonal.bodega
        WHERE sucursal = NEW.sucursal
        AND producto = NEW.producto) < 0 THEN
        RAISE EXCEPTION 'La cantidad en la bodega no puede ser negativa';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_actualizar_inventario_estanteria
BEFORE INSERT ON rcpersonal.estanteria
FOR EACH ROW
EXECUTE FUNCTION actualizar_inventario_estanteria();

--Vista para las 2 sucursales que mas han vendido
CREATE VIEW rcpersonal.top_2_sucursales AS
SELECT s.codigo_sucursal, s.nombre, SUM(v.total) as total_ingresos
FROM rcempleado.sucursal s
JOIN rcempleado.empleado e ON s.codigo_sucursal = e.codigo_sucursal
JOIN rcpersonal.venta v ON e.codigo_empleado = v.codigo_empleado
GROUP BY s.codigo_sucursal, s.nombre
ORDER BY total_ingresos DESC
LIMIT 2;

--Vista para los 10 art mas vendidos
CREATE OR REPLACE VIEW rcpersonal.top_10_articulos AS
SELECT p.codigo_producto, p.nombre, SUM(dv.cantidad) AS cantidad_vendida
FROM rcpersonal.detalleventa dv
JOIN rcpersonal.producto p ON dv.producto = p.codigo_producto
GROUP BY p.codigo_producto, p.nombre
ORDER BY cantidad_vendida DESC
LIMIT 10;

--Vista para los 10 clientes que mas han comprado
CREATE OR REPLACE VIEW rcpersonal.top_10_clientes AS
SELECT c.nit_cliente, c.nombre, SUM(v.total) AS total_gastado
FROM rccliente.cliente c
JOIN rcpersonal.venta v ON c.nit_cliente = v.nit_cliente
GROUP BY c.nit_cliente, c.nombre
ORDER BY total_gastado DESC
LIMIT 10;

--Vista para los clientes con tarjetas asignadas
CREATE OR REPLACE VIEW rccliente.vista_tarjetas_puntos AS
SELECT c.nit_cliente, c.nombre, ct.nombre AS categoria_tarjeta, tp.total_gastado
FROM rccliente.cliente c
JOIN rccliente.tarjetapuntos tp ON c.nit_cliente = tp.nit_cliente
JOIN rccliente.categoriatarjeta ct ON tp.codigo_categoria = ct.codigo_categoria;

--Proceso Almacenado para asignar tarjetas de puntos
CREATE OR REPLACE FUNCTION asignar_tarjeta_puntos()
RETURNS VOID AS $$
DECLARE
    cliente RECORD;
    total_gastado NUMERIC;
BEGIN
    FOR cliente IN
        SELECT c.nit_cliente, SUM(v.total) as total_gastado
        FROM rccliente.cliente c
        JOIN rcpersonal.venta v ON c.nit_cliente = v.nit_cliente
        GROUP BY c.nit_cliente
    LOOP
        total_gastado := cliente.total_gastado;

        IF NOT EXISTS (
            SELECT 1
            FROM rccliente.tarjetapuntos tp
            WHERE tp.nit_cliente = cliente.nit_cliente
        ) THEN
            INSERT INTO rccliente.tarjetapuntos (nit_cliente, codigo_categoria, total_gastado)
            VALUES (cliente.nit_cliente, 1, total_gastado);
        ELSE
            IF total_gastado >= 30000 THEN
                UPDATE rccliente.tarjetapuntos
                SET codigo_categoria = 4, -- Diamante
                    total_gastado = cliente.total_gastado
                WHERE nit_cliente = cliente.nit_cliente;
            ELSIF total_gastado >= 20000 THEN
                UPDATE rccliente.tarjetapuntos
                SET codigo_categoria = 3, -- Platino
                    total_gastado = cliente.total_gastado
                WHERE nit_cliente = cliente.nit_cliente;
            ELSIF total_gastado >= 10000 THEN
                UPDATE rccliente.tarjetapuntos
                SET codigo_categoria = 2, -- Oro
                    total_gastado = cliente.total_gastado
                WHERE nit_cliente = cliente.nit_cliente;
            ELSE
                UPDATE rccliente.tarjetapuntos
                SET codigo_categoria = 1, -- Común
                    total_gastado = cliente.total_gastado
                WHERE nit_cliente = cliente.nit_cliente;
            END IF;
        END IF;
    END LOOP;
END;
$$ LANGUAGE plpgsql;