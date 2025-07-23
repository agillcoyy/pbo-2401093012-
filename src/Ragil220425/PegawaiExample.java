/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil220425;

/**
 *
 * @author Muhamad Soleh
 */
public class PegawaiExample {
    public static void main(String[] args) {
        Pegawai pegawai1 = new Pegawai("123456", "Pak Ervan", "1A");
        pegawai1.tampilkanData();

        System.out.println();

        Pegawai pegawai2 = new Pegawai("789012", "Agil Gendud", "3A");
        pegawai2.tampilkanData();

        System.out.println();

        Pegawai pegawai3 = new Pegawai("345678", "Tama Konstruksi", "3A");
        pegawai3.tampilkanData();
    }

}
