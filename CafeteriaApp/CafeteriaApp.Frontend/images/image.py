import cv2
import csv
from openpyxl import load_workbook
import openpyxl
import scipy.ndimage
import scipy.signal
import scipy.misc
import zlib
import pandas as pd
from xlrd import open_workbook
import operator as i
import os
import numpy as np
#import math as m
import matplotlib.pyplot as plt

img = cv2.imread('register5.jpg')
#img = scipy.ndimage.imread('register5.jpg', flatten=False, mode=None)

#scipy.signal.medfilt(img, kernel_size=None)

#face = scipy.misc.face(gray=False).astype(float)

#img = scipy.ndimage.gaussian_filter(img,3)

#scipy.misc.imshow(img)
#plt.imshow(np.uint8(img))
#plt.show()

# kernel = np.array([[-1,-1,-1], [-1,9,-1], [-1,-1,-1]])
# image = cv2.filter2D(img, -1, kernel)
# cv2.imshow('image',image)

# k = cv2.waitKey(0)
# if k == 27:         # wait for ESC key to exit
#     cv2.destroyAllWindows()
# elif k == ord('s'): # wait for 's' key to save and exit
#     cv2.imwrite('messigray.png',img)
#     cv2.destroyAllWindows()
#plt.imshow(image,)
#cv2.imwrite('myregister.jpg')

# cv2.GaussianBlur(img, img, Size(0, 0), 3)
# cv2.addWeighted(img, 1.5, img, -0.5, 0, img)
# cv2.imshow('image',image)

