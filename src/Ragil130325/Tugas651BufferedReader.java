/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil130325;
import java.io.*;
/**
 *
 * @author Muhamad Soleh
 */
public class Tugas651BufferedReader {
    public static void main(String[] args) throws IOException {
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));

        System.out.print("Masukkan nilai ujian 1: ");
        double nilai1 = Double.parseDouble(br.readLine());

        System.out.print("Masukkan nilai ujian 2: ");
        double nilai2 = Double.parseDouble(br.readLine());

        System.out.print("Masukkan nilai ujian 3: ");
        double nilai3 = Double.parseDouble(br.readLine());

        double rataRata = (nilai1 + nilai2 + nilai3) / 3;

        System.out.println("Nilai rata-rata: " + rataRata);

        if (rataRata >= 60) {
            System.out.println(":)");
        } else {
            System.out.println(":-( ");
        }
    }

}

