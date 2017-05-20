public class TiepTuyen {
    public static final float SAI_SO = 0.000001f;
    public float[] pt, daoHamBac1, daoHamBac2;
    public float xFuture, xNoFuture, min,max,nghiem,m;
    public  int cout;
    public TiepTuyen(){
        pt = new float[11];
        daoHamBac1 = new float[10];
        daoHamBac2 = new float[9];
    }
    public void nhapPhuongTrinh(float x0,float x1,float x2,float x3,float x4,float x5,float x6,
                                float x7,float x8,float x9,float x10, float min,float max){
        pt[0] = x0;
        pt[1] = x1;
        pt[2] = x2;
        pt[3] = x3;
        pt[4] = x4;
        pt[5] = x5;
        pt[6] = x6;
        pt[7] = x7;
        pt[8] = x8;
        pt[9] = x9;
        pt[10] = x10;
        this.min = min;
        this.max = max;
        cout = 0;
    }
    public void giaiPT(){
        daoHamBac1 = TinhToan.daoHam(pt);
        daoHamBac2 = TinhToan.daoHam(daoHamBac1);
        if(TinhToan.thayNghiem(pt,min)* TinhToan.thayNghiem(daoHamBac2,min) > 0){
            xFuture =min;
        }
        else {
            xFuture = max;
        }
        nghiem = xFuture;
        m= Math.min(TinhToan.thayNghiem(daoHamBac1,min), TinhToan.thayNghiem(daoHamBac1,max));
        nghiem = timNghiem(nghiem);
        System.out.println("Giai Phuong trinh theo phuong phap Tiep TUyen : ");
        System.out.println("Nghiem la  : " + nghiem);
        System.out.println("So lan Lap Hoi Tu : " + cout);

    }

    public float timNghiem(float x) {
        cout ++;
        float x1 = x - TinhToan.thayNghiem(pt, x) / TinhToan.thayNghiem(daoHamBac1, x);
        if (Math.abs(x1 - x) / m < SAI_SO) {
            return x1;
        }
        return timNghiem(x1);
    }
}
