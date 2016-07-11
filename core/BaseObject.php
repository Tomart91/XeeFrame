<?php

namespace core;

/**
 * Podstawowy obiekt systemu
 *
 * @author Tomasz
 */
abstract class BaseObject {

	/**
	 * Dane obiektu
	 * @var <Array> 
	 */
	private $valueMap;

	/**
	 * Funkcja pobierajaca wartość z obiektu
	 * @param <string> $key Klucz wartości która chcemy pobrać
	 * @return <mixed>
	 */
	public final function get($key) {
		if (isset($this->valueMap[$key])) {
			return $this->valueMap[$key];
		} else {
			return false;
		}
	}

	/**
	 * Funkcja sprawdzajaca czy zmienna znajduje sie w obiekcie
	 * @param <string> $key Klucz do wartości która chcemy sprawdzić
	 * @return <boolean>
	 */
	public final function has($key) {
		return isset($this->valueMap[$key]);
	}

	/**
	 * Funkcja wpisujaca/aktualizujaca dane w obiekcie
	 * @param <string> $key Klucz po którym wartość będzie widziana w obiekcie
	 * @param <mixed> $value
	 */
	public final function set($key, $value) {
		$this->valueMap[$key] = $value;
	}

	/**
	 * Funkcja ustawiajaca wszystkie pola w obiekcie
	 * @param <Array> $data Dane do wpisania
	 */
	public final function setData($data) {
		$this->valueMap = $data;
	}

	/**
	 * Funkcja pobierajaca wszystkie dane obiektu
	 * @return <Array> Dane obiektu
	 */
	public final function getData() {
		return $this->valueMap;
	}

}
