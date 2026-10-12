# 
#!/usr/bin/env python3
# -*- coding: utf-8 -*-

from pathlib import Path
import hashlib
import shutil
import logging
from datetime import datetime


def calcular_sha256(archivo: Path) -> str:
    """Calcula la huella digital SHA-256 de un archivo."""
    sha256 = hashlib.sha256()

    with archivo.open("rb") as entrada:
        for bloque in iter(
            lambda: entrada.read(1024 * 1024), b""
        ):
            sha256.update(bloque)

    return sha256.hexdigest()


def organizar_archivos(origen: str, destino: str) -> None:
    """Copia archivos PHP y verifica su integridad."""

    carpeta_origen = Path(origen).resolve()
    carpeta_destino = Path(destino).resolve()

    if not carpeta_origen.is_dir():
        raise FileNotFoundError(
            f"No existe la carpeta de origen: {carpeta_origen}"
        )

    if (
        carpeta_destino == carpeta_origen
        or carpeta_origen in carpeta_destino.parents
    ):
        raise ValueError(
            "El destino no puede estar dentro del origen."
        )

    carpeta_destino.mkdir(parents=True, exist_ok=True)

    for archivo in sorted(carpeta_origen.iterdir()):
        if not archivo.is_file() or archivo.suffix.lower() != ".php":
            continue

        marca = datetime.now().strftime("%Y%m%d-%H%M%S")
        nombre = f"shopfx_{archivo.stem}_{marca}.php"
        destino_archivo = carpeta_destino / nombre

        # Evita sobrescribir archivos existentes.
        contador = 2
        while destino_archivo.exists():
            nombre = (
                f"shopfx_{archivo.stem}_{marca}_{contador}.php"
            )
            destino_archivo = carpeta_destino / nombre
            contador += 1

        hash_original = calcular_sha256(archivo)
        shutil.copy2(archivo, destino_archivo)
        hash_copia = calcular_sha256(destino_archivo)

        if hash_original == hash_copia:
            logging.info(
                "COPIA VERIFICADA: %s", destino_archivo.name
            )
        else:
            destino_archivo.unlink(missing_ok=True)
            logging.error(
                "ERROR DE INTEGRIDAD: %s", archivo.name
            )


if __name__ == "__main__":
    logging.basicConfig(
        level=logging.INFO,
        format="%(asctime)s | %(levelname)s | %(message)s",
    )

    organizar_archivos(
        origen=r"C:\xampp8\htdocs\shopfx",
        destino=r"C:\ShopFX_Backup",
    ) 
  
#!/usr/bin/env python3
# -*- coding: utf-8 -*-

from pathlib import Path
import hashlib
import shutil
import logging
from datetime import datetime


def calcular_sha256(archivo: Path) -> str:
    """Calcula la huella digital SHA-256 de un archivo."""
    sha256 = hashlib.sha256()

    with archivo.open("rb") as entrada:
        for bloque in iter(
            lambda: entrada.read(1024 * 1024), b""
        ):
            sha256.update(bloque)

    return sha256.hexdigest()


def organizar_archivos(origen: str, destino: str) -> None:
    """Copia archivos PHP y verifica su integridad."""

    carpeta_origen = Path(origen).resolve()
    carpeta_destino = Path(destino).resolve()

    if not carpeta_origen.is_dir():
        raise FileNotFoundError(
            f"No existe la carpeta de origen: {carpeta_origen}"
        )

    if (
        carpeta_destino == carpeta_origen
        or carpeta_origen in carpeta_destino.parents
    ):
        raise ValueError(
            "El destino no puede estar dentro del origen."
        )

    carpeta_destino.mkdir(parents=True, exist_ok=True)

    for archivo in sorted(carpeta_origen.iterdir()):
        if not archivo.is_file() or archivo.suffix.lower() != ".php":
            continue

        marca = datetime.now().strftime("%Y%m%d-%H%M%S")
        nombre = f"shopfx_{archivo.stem}_{marca}.php"
        destino_archivo = carpeta_destino / nombre

        # Evita sobrescribir archivos existentes.
        contador = 2
        while destino_archivo.exists():
            nombre = (
                f"shopfx_{archivo.stem}_{marca}_{contador}.php"
            )
            destino_archivo = carpeta_destino / nombre
            contador += 1

        hash_original = calcular_sha256(archivo)
        shutil.copy2(archivo, destino_archivo)
        hash_copia = calcular_sha256(destino_archivo)

        if hash_original == hash_copia:
            logging.info(
                "COPIA VERIFICADA: %s", destino_archivo.name
            )
        else:
            destino_archivo.unlink(missing_ok=True)
            logging.error(
                "ERROR DE INTEGRIDAD: %s", archivo.name
            )


if __name__ == "__main__":
    logging.basicConfig(
        level=logging.INFO,
        format="%(asctime)s | %(levelname)s | %(message)s",
    )

    organizar_archivos(
        origen=r"C:\xampp8\htdocs\shopfx",
        destino=r"C:\ShopFX_Backup",
    ) 
